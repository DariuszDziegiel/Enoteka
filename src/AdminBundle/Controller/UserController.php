<?php
namespace AdminBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/user", defaults={"_locale": "pl"})
 */
class UserController extends  Controller {

    /**
     * @Breadcrumb("admin_users_list", routeName="admin_users_list")
     * @Route("/list", name="admin_users_list")
     */
    public function usersListAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        
        $usersQuery = $em->getRepository('AdminBundle:User')->getAll(true);
        $paginator = $this->get('knp_paginator');

        $users = $paginator->paginate(
            $usersQuery,
            $request->query->get('page', 1),
            50
        );
        
        return $this->render('@Admin/User/admin_users_list.html.twig', [
            'users' => $users
        ]);

    }
    
    
    
    
    
}

