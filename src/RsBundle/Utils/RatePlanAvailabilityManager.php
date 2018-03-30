<?php
namespace RsBundle\Utils;

use Doctrine\ORM\EntityManager;
use RsBundle\Entity\RsBasePriceRatePlanFormula;
use RsBundle\Entity\RsBaseRoomFormula;
use RsBundle\Entity\RsRatePlan;
use RsBundle\Entity\RsRatePlanAvailability;
use RsBundle\Entity\RsRoom;

class RatePlanAvailabilityManager {

    private $_em;
    private $_rsRoomEntity;
    private $_childRooms = null;

    private $_rsRatePlanEntity;
    private $_childPriceRatePlans = null;

    private $_dateHelper;
    
    public function __construct(RsRoom $rsRoomEntity, RsRatePlan $rsRatePlanEntity, EntityManager $em, DateHelper $dateHelper)
    {
        $this->_rsRoomEntity  = $rsRoomEntity;
        $this->_rsRatePlanEntity    = $rsRatePlanEntity;
        $this->_em = $em;
        $this->_dateHelper = $dateHelper;

        $this->_childRooms = $this->_getChildRooms();
        $this->_childPriceRatePlans = $this->_getChildPriceRatePlans();

    }
    
    /**
     * Get child rate plans
     * @return array
     */
    private function _getChildPriceRatePlans() {
        return $this->getEntityManager()
            ->getRepository('RsBundle:RsRatePlan')
            ->getByBasePriceRatePlan($this->getRsRatePlanEntity());
    }

    /**
     * Get child rooms
     * @return array
     */
    private function _getChildRooms() {
        return $this->getEntityManager()
            ->getRepository('RsBundle:RsRoom')
            ->getByBaseRoom($this->getRsRoomEntity());
    }

    /**
     * @param $dateFrom
     * @param $dateTo
     * @throws CalendarException
     */
    public function setRatePlanAvailabilityForPeriod($dateFrom, $dateTo, $params) {
        $periodDates = $this->getDateHelper()
            ->preparePeriodDates($dateFrom, $dateTo)['periodDates'];
        foreach ($periodDates as $date) {
            $this->setRatePlanAvailabilityForDate($date, $params);
        }
    }

    /**
     * @param $params  ['date'/'priceRoom']
     */
    public function setRatePlanAvailabilityForDate($date, $params) {
        // @TODO: Validate Params
        $isNew = false;

        // @TODO: move code to repository
        $rsRatePlanAvailabilityEntity = $this->getEntityManager()
            ->getRepository('RsBundle:RsRatePlanAvailability')
            ->getOneByRatePlanAndRoom($this->getRsRoomEntity(), $this->getRsRatePlanEntity(), $date);
        if (!$rsRatePlanAvailabilityEntity) {
            $isNew = true;
            $rsRatePlanAvailabilityEntity = new RsRatePlanAvailability();
            $rsRatePlanAvailabilityEntity->setRoom($this->getRsRoomEntity());
            $rsRatePlanAvailabilityEntity->setRatePlan($this->getRsRatePlanEntity());
            $rsRatePlanAvailabilityEntity->setDate($date);
        }

        if (isset($params['priceRoom'])) {
            $rsRatePlanAvailabilityEntity->setPriceRoom($params['priceRoom']);
        }
        if (isset($params['priceSurcharge'])) {
            $rsRatePlanAvailabilityEntity->setPriceSurcharge($params['priceSurcharge']);
        }
        if (isset($params['minStayDays'])) {
            $rsRatePlanAvailabilityEntity->setMinStayDays($params['minStayDays']);
        }
        if (isset($params['allotment'])) {
            $rsRatePlanAvailabilityEntity->setAllotment($params['allotment']);
        }

        if ($isNew) {
            $this->getEntityManager()->persist($rsRatePlanAvailabilityEntity); 
        }
        $this->getEntityManager()->flush();

        //Calculate children plans
        if (isset($params['priceRoom'])) {
            $this->setChildrensAvailabilityForDate($date, $rsRatePlanAvailabilityEntity);
        }

    }
    
    
    /**
     * @param array $params ['date' / 'priceSurcharge'] 
     */
    public function setPriceSurchargeForDate($params) {
        // @TODO: Validate Params
        $isNew = false;
        $rsRatePlanAvailabilityEntity = $this->getEntityManager()
            ->getRepository('RsBundle:RsRatePlanAvailability')
            ->getOneByRatePlanAndRoom($this->getRsRoomEntity(), $this->getRsRatePlanEntity(), $params['date']);
        if (!$rsRatePlanAvailabilityEntity) {
            $isNew = true;
            $rsRatePlanAvailabilityEntity = new RsRatePlanAvailability();
            $rsRatePlanAvailabilityEntity->setRoom($this->getRsRoomEntity());
            $rsRatePlanAvailabilityEntity->setRatePlan($this->getRsRatePlanEntity());
            $rsRatePlanAvailabilityEntity->setDate($params['date']);
        }
        $rsRatePlanAvailabilityEntity->setPriceSurcharge($params['priceSurcharge']);
        if ($isNew) {
            $this->getEntityManager()->persist($rsRatePlanAvailabilityEntity);
        }
        $this->getEntityManager()->flush();
    }

    
    /**
     * @param $date
     */
    public function setChildrensAvailabilityForDate($date, RsRatePlanAvailability $rsRatePlanAvailability) {
        $childrenRatePlans=$this->getChildPriceRatePlans();
        if (empty($childrenRatePlans)) {
            return;
        }
        $isNew = false;
        /** @var $childrenRatePlan RsRatePlan */
        foreach ($childrenRatePlans as $childrenRatePlan) {
            //$childrenRatePlan->getBasePriceRatePlanFormulas();
            $rsRatePlanAvailabilityEntity = $this->getEntityManager()
                ->getRepository('RsBundle:RsRatePlanAvailability')
                ->getOneByRatePlanAndRoom($this->getRsRoomEntity(), $childrenRatePlan, $date);

            if (!$rsRatePlanAvailabilityEntity) {
                $isNew = true;
                $rsRatePlanAvailabilityEntity = new RsRatePlanAvailability();
                $rsRatePlanAvailabilityEntity->setRoom($this->getRsRoomEntity());
                $rsRatePlanAvailabilityEntity->setRatePlan($childrenRatePlan);
                $rsRatePlanAvailabilityEntity->setDate($date);
            }
            //calculate price form Whole Room
            $price = $rsRatePlanAvailability->getPriceRoom();
            $price  = $this->applyBasePriceRatePlanFormulas($childrenRatePlan, $price);
            
            $rsRatePlanAvailabilityEntity->setPriceRoom($price);
            if ($isNew) {
                $this->getEntityManager()->persist($rsRatePlanAvailabilityEntity);
            }
        }
        
        $childrenRooms = $this->getChildRooms();
        /** @var RsRoom $childrenRoom */
        foreach ($childrenRooms as $childrenRoom) {
            $isNew = false;
            //PLAN STANDARD
            $rsRatePlanAvailabilityEntity = $this->getEntityManager()
                ->getRepository('RsBundle:RsRatePlanAvailability')
                ->getOneByRatePlanAndRoom($childrenRoom, $rsRatePlanAvailability->getRatePlan(), $date);

            if (!$rsRatePlanAvailabilityEntity) {
                $isNew = true;
                $rsRatePlanAvailabilityEntity = new RsRatePlanAvailability();
                $rsRatePlanAvailabilityEntity->setRoom($childrenRoom);
                $rsRatePlanAvailabilityEntity->setRatePlan($rsRatePlanAvailability->getRatePlan());
                $rsRatePlanAvailabilityEntity->setDate($date);
            }
            //calculate price
            $price = $rsRatePlanAvailability->getPriceRoom();
            $price = $this->applyBaseRoomFormulas($childrenRoom, $price);

            $rsRatePlanAvailabilityEntity->setPriceRoom($price);
            if ($isNew) {
                $this->getEntityManager()->persist($rsRatePlanAvailabilityEntity);
            }

            /** @var $childrenRatePlan RsRatePlan */
            foreach ($childrenRatePlans as $childrenRatePlan) {
                $isNew = false;
                //$childrenRatePlan->getBasePriceRatePlanFormulas();
                $rsRatePlanAvailabilityEntity = $this->getEntityManager()
                    ->getRepository('RsBundle:RsRatePlanAvailability')
                    ->getOneByRatePlanAndRoom($childrenRoom, $childrenRatePlan, $date);

                if (!$rsRatePlanAvailabilityEntity) {
                    $isNew = true;
                    $rsRatePlanAvailabilityEntity = new RsRatePlanAvailability();
                    $rsRatePlanAvailabilityEntity->setRoom($childrenRoom);
                    $rsRatePlanAvailabilityEntity->setRatePlan($childrenRatePlan);
                    $rsRatePlanAvailabilityEntity->setDate($date);
                }
                //calculate price
                $price = $rsRatePlanAvailability->getPriceRoom();
                $price = $this->applyBasePriceRatePlanFormulas($childrenRatePlan, $price);
                $price = $this->applyBaseRoomFormulas($childrenRoom, $price);

                $rsRatePlanAvailabilityEntity->setPriceRoom($price);

                if ($isNew) {
                    $this->getEntityManager()->persist($rsRatePlanAvailabilityEntity);
                }

            }
            $this->getEntityManager()->flush();
        }

    }


    /**
     * @param RsRatePlan $rsRatePlan
     * @param $price
     * @return mixed
     */
    protected function applyBasePriceRatePlanFormulas(RsRatePlan $rsRatePlan, $price) {
        $formulaColl = $rsRatePlan->getActiveBasePriceRatePlanFormulas();
        if (!$formulaColl) {
            return $price;
        }
        /** @var RsBasePriceRatePlanFormula $formula */
        foreach ($formulaColl as $formula) {
            $price = $formula->applyFormula($price);
        }
        return $price;
    }


    /**
     * @param RsRoom $rsRoom
     * @param $price
     * @return mixed
     */
    protected function applyBaseRoomFormulas(RsRoom $rsRoom, $price) {
        $formulaColl = $rsRoom->getActiveBaseRoomFormulas();
        if (!$formulaColl) {
            return $price;
        }
        /** @var RsBaseRoomFormula $formula */
        foreach ($formulaColl as $formula) {
            $price = $formula->applyFormula($price);
        }
        return $price;
    }

    
    //------------------------------------------------
    public function getRsRoomEntity() : RsRoom {
        return $this->_rsRoomEntity;
    }

    public function getRsRatePlanEntity() : RsRatePlan {
        return $this->_rsRatePlanEntity;
    }

    public function getEntityManager() : EntityManager {
        return $this->_em;
    }

    public function getChildPriceRatePlans() {
        return $this->_childPriceRatePlans;
    }

    public function getChildRooms() {
        return $this->_childRooms;
    }

    public function getDateHelper() : DateHelper {
        return $this->_dateHelper;
    }


}