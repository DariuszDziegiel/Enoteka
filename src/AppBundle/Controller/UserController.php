<?php
namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Breadcrumb("user_profile", routeName="user_profile")
     * @Route("/profile", name="user_profile")
     */
    public function profileAction() {
        return $this->render('@App/User/user_profile.html.twig');
    }
    
    /**
     * @Breadcrumb("user_profile", routeName="user_profile")
     * @Breadcrumb("user_profile_edit", routeName="user_profile_edit")
     * @Route("/profile/edit", name="user_profile_edit")
     */
    public function profileEditAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('AdminBundle:User');

        $userEntity = $userRepository->findOneBy([
            'id' => $this->getUser()->getId()
        ]);

        $form = $this->createForm(UserType::class, $userEntity, [
            'validation_groups' => ['ProfileEdit']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $userRepository->save($userEntity);
                $this->addFlash('form_success', true);
            }
        }
        return $this->render('@App/User/partials/user_profile_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


  
    
    
    
    
    

}
