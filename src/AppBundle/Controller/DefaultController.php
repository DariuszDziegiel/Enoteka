<?php

namespace AppBundle\Controller;


use AdminBundle\Entity\CmsArticleCategory;
use AdminBundle\Entity\CmsStaticPage;
use AdminBundle\Form\CmsNewsletterMailType;
use AdminBundle\Repository\CmsArticleCategoryRepository;
use Doctrine\Common\Collections\Criteria;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}", name="homepage", defaults={"_locale": "pl"})
     */
    public function indexAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        //get active packages
        $rsPackages = $entityManager->getRepository('RsBundle:RsPackage')->getActive();
        //articles
        $cmsArticles = $entityManager->getRepository('AdminBundle:CmsArticle')->getActive(3);

        //menu section
        $menuCategory = $entityManager->getRepository('AdminBundle:CmsCategory')->findOneBy(['code' => 'menu']);
        $menuPages = $entityManager->getRepository('AdminBundle:CmsPage')->getPagesByCategory($menuCategory);
        

       return $this->render('@App/Default/index.html.twig', [
           'rsPackages'  => $rsPackages,
           'news'        => $cmsArticles,
           'menuPages'   => $menuPages
       ]);
    }


    /**
     * @Route("/service/under_construction", name="under_construction")
     */
    public function underConstructionAction() {
        return $this->render('@App/Default/under_construction.html.twig');
    }

    /**
     * Main menu render
     * @return Response
     */
    public function menuCategoryAction($cmsCategoryCode) {
        $em = $this->getDoctrine()->getManager();
        //cmsCategory
        $cmsCategory = $em->getRepository('AdminBundle:CmsCategory')->findOneBy(['code' => $cmsCategoryCode]);
        
        //get pages by cmsCategory
        $cmsPages = $em->getRepository('AdminBundle:CmsPage')->getPagesByCategory($cmsCategory);
        
        return $this->render('@App/Default/menu_category.html.twig', [
            'cmsCategory' => $cmsCategory,
            'cmsPages'    => $cmsPages
        ]);
    }


    
}
