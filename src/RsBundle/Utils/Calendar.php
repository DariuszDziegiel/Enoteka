<?php
namespace RsBundle\Utils;

use Doctrine\ORM\EntityManager;
use RsBundle\Entity\RsRatePlanAvailability;
use Symfony\Component\Validator\Constraints\DateTime;

class Calendar {

    /** @var \DateTime */
    protected $dateFrom;
    /** @var \DateTime  */
    protected $dateTo;
    /** @var array */
    protected $periodDates;
    /** @var \DateTime  */
    protected $dateNow;
    /** @var EntityManager */
    protected $em;
    /** @var array */
    protected $ratePlanAvailabilities;

    protected $dateHelper;

    public function __construct($dateFrom = null, $dateTo = null, EntityManager $em, DateHelper $dateHelper)
    {
        $this->dateHelper = $dateHelper;
        $preparedDates = $this->getDateHelper()
            ->preparePeriodDates($dateFrom, $dateTo);
        
        $this->dateFrom     = $preparedDates['dateFrom'];
        $this->dateTo       = $preparedDates['dateTo'];
        $this->dateNow      = new \DateTime('now');
        $this->periodDates  = $preparedDates['periodDates'];
        $this->em = $em;
        $this->ratePlanAvailabilities = $this->getRatePlanAvailabilityByPeriod();
    }

    
    /**
     * Get calendar dates from given period
     * @return array
     */
    public function getCalendarDates() {
        $calendarDates = [];
        $periodDates = $this->getPeriodDates();
        /** @var $date \DateTime*/
        foreach ($periodDates as $date ) {
               $calendarDates[] = [
                   'date'  => $date->format('Y-m-d'),
                   'year'  => $date->format('Y'),
                   'month' => $date->format('m'),
                   'day'   => $date->format('d'),
                   'dayOfWeek' => $date->format('N')
               ];
        }
        return $calendarDates;
    }

    /**
     * @param null $dateFrom
     * @param null $dateTo
     * @return array|null
     */
    public function getRatePlanAvailabilityByPeriod($dateFrom = null, $dateTo = null) {
        if ($dateFrom && $dateTo) {
               $dateFrom = new \DateTime($dateFrom);
               $dateTo = new \DateTime($dateTo);
        } else {
            $dateFrom = $this->getDateFrom();
            $dateTo   = $this->getDateTo(); 
        }
        $rsRatePlanAvailabilityColl = $this->getEntityManager()
            ->getRepository('RsBundle:RsRatePlanAvailability')
            ->getAllByDatePeriod($dateFrom, $dateTo);
        if (empty($rsRatePlanAvailabilityColl)) {
            return null;
        }
        $result = [];
        /** @var RsRatePlanAvailability $rpaEntity */
        foreach ($rsRatePlanAvailabilityColl as $rpaEntity) {
            $result[$rpaEntity->getDate()->format('Y-m-d')][$rpaEntity->getRoom()->getId()][$rpaEntity->getRatePlan()->getId()] = $rpaEntity;
        }
        return $result;
    }

    /**
     * @param $date
     * @param $roomId
     * @param $ratePlanId
     * @return mixed
     */
    public function getRatePlanAvailabilityForDateAndRoom($date, $roomId, $ratePlanId) {
        if (!$this->ratePlanAvailabilities) {
            return false;
        }
        if (!array_key_exists($date, $this->ratePlanAvailabilities)) {
            return false;
        }
        if (!array_key_exists($roomId, $this->ratePlanAvailabilities[$date])) {
            return false;
        }
        if (!array_key_exists($ratePlanId, $this->ratePlanAvailabilities[$date][$roomId])) {
            return false;
        }
        return $this->ratePlanAvailabilities[$date][$roomId][$ratePlanId];
    }

    //-------------------------------------------------------------------------------------------------------------------
    /**
     * @return \DateTime
     */
    public function getDateFrom() : \DateTime {
        return $this->dateFrom;
    }

    public function getDateTo() : \DateTime {
        return $this->dateTo;
    }

    public function getPeriodDates() {
        return $this->periodDates;
    }

    public function getDateNow() : \DateTime {
        return $this->dateNow;
    }

    public function getEntityManager() : EntityManager {
        return $this->em;
    }

    public function getDateHelper() : DateHelper {
        return $this->dateHelper;
    }

}


class CalendarException extends \Exception {

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
}