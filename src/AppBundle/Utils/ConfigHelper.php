<?php
namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;

class ConfigHelper {

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get CmsConfig value by key
     * @param $key
     * @return string
     */
    public function getValue($key) {
        return $this->entityManager->getRepository('AdminBundle:CmsConfig')->getValueByKey($key);
    }

    /**
     * Get CmsConfig value by key
     * @param $key
     * @return string
     */
    public function getByKey($key) {
        return $this->entityManager->getRepository('AdminBundle:CmsConfig')->getByKey($key);
    }

    
    public function getCmsStaticPageByParam($param) {
        return $this->entityManager->getRepository('AdminBundle:CmsStaticPage')->getByParam($param);
    }
}