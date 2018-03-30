<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CmsCategoryController extends Controller
{

    /**
     * @Route("/konkursy_kategorie", name="categories_list")
     */
    public function categoriesListAction() {
        $em = $this->getDoctrine()->getManager();
        $cmsCategoryRepo = $em->getRepository('AdminBundle:CmsCategory');

        /** Get active categories */
        $cmsCategories = $cmsCategoryRepo->getActiveTree();
        
        
        return $this->render('@App/CmsCategory/categories_list.html.twig', [
            'cmsCategories'       => $cmsCategories,
            'cmsCategorySelected' => false
        ]);
    }



}