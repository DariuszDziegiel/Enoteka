<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/{_locale}/galeria")
 */
class GalleryController extends Controller {

    /**
     * @Route("/", name="gallery_index")
     */
    public function indexAction() {
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/{slug}", name="gallery_details")
     */
    public function detailsAction($slug) {
        $em = $this->getDoctrine()->getManager();
        $cmsGallery = $em->getRepository('AdminBundle:CmsGallery')->getBySlug($slug);
        if (!$cmsGallery) {
            return $this->redirectToRoute('homepage');
        }

        //gallery files
        $cmsGalleryFiles = $em->getRepository('AdminBundle:CmsGalleryFile')->getFilesByCmsGallery($cmsGallery);
        
        //active Galleries
        $cmsGalleries = $em->getRepository('AdminBundle:CmsGallery')->getActive();
        
        return $this->render('@App/Gallery/gallery_index.html.twig', [
            'cmsGalleries'    => $cmsGalleries,
            'cmsGallery'      => $cmsGallery,
            'cmsGalleryFiles' => $cmsGalleryFiles
        ]);
    }

    /**
     * @Route("/g/wirtualny-spacer", name="gallery_virtual_tour")
     */
    public function virtualTourAction() {
        $em = $this->getDoctrine()->getManager();
        
        //active Galleries
        $cmsGalleries = $em->getRepository('AdminBundle:CmsGallery')->getActive();
        
        return $this->render('@App/Gallery/gallery_virtual_tour.html.twig', [
            'cmsGalleries' => $cmsGalleries
        ]);
    }
    
    
    







}