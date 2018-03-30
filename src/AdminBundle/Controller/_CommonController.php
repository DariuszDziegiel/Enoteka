<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class _CommonController
 * @package AdminBundle\Controller
 *
 */
class _CommonController extends Controller
{


    /**
     * Get admin menu
     */
    public function getMenuAction($currentRouteName = null) {
        $menuXml = simplexml_load_file(__DIR__. '/../Resources/config/menu.xml');
        return $this->render('AdminBundle:_Common:menu.html.twig', array('menu' => $menuXml, 'currentRoute' => $currentRouteName));
    } 
    
}
