<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\User;
use AdminBundle\Form\ChangePasswordType;
use AdminBundle\Form\Model\ChangePassword;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * @Route("/admin")
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="admin_login")
     */
    public function loginAction() {
        //redirect if admin is logged in
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_default');
        }
    
        
        /** @var $authUtils AuthenticationUtils */
        $authUtils = $this->get('security.authentication_utils');
        //get login error
        $error = $authUtils->getLastAuthenticationError();
        //get last username entered
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('AdminBundle:Security:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error
        ));
    }

    /**
     * @Route("/logout", name="admin_logout")
     */
    public function logoutAction() {
        return new Response('admin logout');
    }


    /**
     * @Route("/password_change", name="admin_password_change")
     * @Security("has_role('ROLE_ADMIN')")
     * @Breadcrumb("admin_password_change")
     */
    public function passwordChangeAction(Request $request) {

        $passwordChangeModel = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $passwordChangeModel);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $passwordEncoder = $this->get('security.password_encoder');
            /** @var User $user */
            $user = $this->getUser();
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('newPassword')->getData()));
            $user->setIsDefaultPasswordChanged(1);
            $entityManager->flush();

            $this->addFlash('password_change_success', true);
        }
        
        return $this->render('@Admin/Security/admin_security_password_change.html.twig', [
            'form' => $form->createView()
        ]);
    }



}
