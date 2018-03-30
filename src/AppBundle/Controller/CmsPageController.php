<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\CmsCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CmsPageController extends Controller
{

    /**
     * @Route("/{_locale}/kategoria/{cmsCategorySlug}", name="cms_page_category")
     * @Route("/{_locale}/category/{cmsCategorySlug}", name="cms_page_category")
     */
    public function categoryAction($cmsCategorySlug) {
        $em = $this->getDoctrine()->getManager();

        //category
        /** @var CmsCategory $cmsCategory */
        $cmsCategory = $em->getRepository('AdminBundle:CmsCategory')->getOneBySlug($cmsCategorySlug);
        if (!$cmsCategory) {
            return $this->redirectToRoute('homepage');
        }

        //all pages in category
        $cmsPages = $em->getRepository('AdminBundle:CmsPage')->getPagesByCategory($cmsCategory);
        
        $cmsStaticPage  = $em->getRepository('AdminBundle:CmsStaticPage')->getByParam($cmsCategory->getCode());
        if (!$cmsStaticPage) {
            return $this->redirectToRoute('homepage');
        }
        

        return $this->render('@App/CmsPage/cms_page_category.html.twig', [
            'cmsStaticPage' => $cmsStaticPage,
            'cmsCategory' => $cmsCategory,
            'cmsPages'    => $cmsPages
        ]);
    }




    /**
     * @Route("/{_locale}/kategoria/{cmsCategorySlug}/{cmsPageSlug}", name="cms_page_details")
     */
    public function detailsAction($cmsCategorySlug, $cmsPageSlug) {
        $em = $this->getDoctrine()->getManager();

        //category
        $cmsCategory = $em->getRepository('AdminBundle:CmsCategory')->getOneBySlug($cmsCategorySlug);
        if (!$cmsCategory) {
            return $this->redirectToRoute('homepage');
        }

        //page
        $cmsPage = $em->getRepository('AdminBundle:CmsPage')->getOneBySlug($cmsPageSlug);

        //all pages in category
        $cmsPages = $em->getRepository('AdminBundle:CmsPage')->getPagesByCategory($cmsCategory);

        return $this->render('@App/CmsPage/cms_page_details.html.twig', [
            'cmsCategory' => $cmsCategory,
            'cmsPage'     => $cmsPage,
            'cmsPages'    => $cmsPages
        ]);
    }

}
