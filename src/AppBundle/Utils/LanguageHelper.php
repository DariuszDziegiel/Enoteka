<?php
namespace AppBundle\Utils;
use Doctrine\ORM\EntityManager;

class LanguageHelper {

    protected $_em;

    public function __construct(EntityManager $em)
    {
        $this->_em = $em;
    }

    public function getActiveLocales() {
        return $this->_em->getRepository('AdminBundle:CmsLanguage')->getActiveCodes();
    }

    public function getActivePageLanguages() {
        return $this->_em->getRepository('AdminBundle:CmsLanguage')->getActivePageLanguages();
    }
    
}