<?php

namespace AdminBundle\Controller;


use AdminBundle\Entity\CmsGallery;
use AdminBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/admin")
 */
class DefaultController extends Controller
{

    /**
     * @Route("/", name="admin_default")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        /** @var $user User */
        if (!$this->getUser()->getIsDefaultPasswordChanged()) {
            $this->addFlash('default_password_change_required', true);
            return $this->redirectToRoute('admin_password_change');
        }
        $em = $this->getDoctrine()->getManager();
        $menuXml = simplexml_load_file(__DIR__. '/../Resources/config/menu.xml');
        


        return $this->render('AdminBundle:Default:admin_default_index.html.twig', [
            'menu'                    => $menuXml
        ]);
    }
    




    
  

    
    
    
    
}
