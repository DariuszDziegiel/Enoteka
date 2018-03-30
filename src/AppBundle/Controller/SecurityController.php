<?php
namespace AppBundle\Controller;

use AdminBundle\Form\ChangePasswordType;
use AdminBundle\Form\Model\ChangePassword;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/user")
 */
class SecurityController extends Controller
{

    /**
     * @Breadcrumb("user_login", routeName="user_login")
     * @Route("/login", name="user_login")
     */
    public function loginAction() {
        //redirect to homepage if is logged in
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        $authUtils = $this->get('security.authentication_utils');
        //get login error
        $error = $authUtils->getLastAuthenticationError();
        //get last username entered
        $lastUsername = $authUtils->getLastUsername();
        
        return $this->render('@App/Security/user_login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logoutAction() {
        

        return new Response('user logout');
    }

    /**
     * @Route("/password_change", name="user_password_change")
     */
    public function passwordChangeAction(Request $request) {
        //access control
        $this->denyAccessUnlessGranted(['ROLE_ORGANIZER', 'ROLE_AUTOR']);
        
        $passwordChangeModel = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $passwordChangeModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $passwordEncoder = $this->get('security.password_encoder');
            /** @var User $user */
            $user = $this->getUser();
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('newPassword')->getData()));
            $user->setIsDefaultPasswordChanged(1);
            $em->flush();
            $this->addFlash('password_change_success', true);
        }
        
        return $this->render('@App/Security/user_password_change.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/login/check-facebook", name="check_facebook")
     */
    public function checkFacebookAction() {
        
    }


    /**
     * @Route("/login/check-google", name="check_google")
     */
    public function checkGoogleAction() {


    }


}