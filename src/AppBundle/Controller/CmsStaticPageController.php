<?php
namespace AppBundle\Controller;

use AdminBundle\Entity\CmsStaticPage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CmsStaticPageController extends Controller {
    
    /**
     * @Route("/{_locale}/strona/{slug}", name="cms_static_page")
     */
    public function cmsStaticPageDetailsAction($slug) {
        /** @var $cmsStaticPage CmsStaticPage*/
        $em = $this->getDoctrine()->getManager();

        $cmsStaticPage = $em->getRepository('AdminBundle:CmsStaticPage')
            ->getBySlug($slug);
        
        if (!$cmsStaticPage) {
            return $this->redirectToRoute('homepage');
        }

        //breadcrumb
        $this->get('apy_breadcrumb_trail')
            ->add($cmsStaticPage->getTitle(), 'cms_static_page', [
                'slug' => $cmsStaticPage->getSlug()
            ]);
        
        //change template to render
        $template = null;
        switch ($cmsStaticPage->getParam()) {
            case 'localisation':
                $template = 'page_localisation.html.twig';
                break;
            case 'gallery':
                $template = 'page_gallery.html.twig';
                break;
            default:
                $template = 'cms_static_page_details.html.twig';
        }

        //get page images
        $images = $em->getRepository('AdminBundle:CmsStaticPageFile')->getFilesByCmsStaticPage($cmsStaticPage);
        
        return $this->render('@App/CmsStaticPage/'. $template, [
            'cmsStaticPage' => $cmsStaticPage,
            'images'        => $images
        ]);

    }



    
}
