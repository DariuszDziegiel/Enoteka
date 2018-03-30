<?php
namespace AppBundle\Controller;

use RsBundle\Entity\RsPackage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/{_locale}/degustacje")
 * @Route("/{_locale}/tastings")
 */
class PackagesController extends Controller {

    /**
     * @Route("/", name="packages_index")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $rsPackages = $em->getRepository('RsBundle:RsPackage')->getActive();

        return $this->render('@App/Packages/packages_index.html.twig', [
            'rsPackages' => $rsPackages
        ]);
    }

    /**
     * @Route("/{slug}", name="packages_details")
     */
    public function detailsAction($slug) {
        $em = $this->getDoctrine()->getManager();

        /** @var RsPackage $rsPackage */
        $rsPackage = $em->getRepository('RsBundle:RsPackage')->getBySlug($slug);
        if (!$rsPackage || !$rsPackage->getIsActive()) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('@App/Packages/packages_details.html.twig', [
            'rsPackage' => $rsPackage
        ]);
    }





}