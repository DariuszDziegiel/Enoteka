<?php
namespace AppBundle\Utils\CmsMessageBox;

use Doctrine\ORM\EntityManager;

class CmsMessageBoxManager {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
}