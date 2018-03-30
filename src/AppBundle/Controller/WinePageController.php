<?php
namespace AppBundle\Controller;

use AdminBundle\Entity\CmsStaticPage;
use AppBundle\Utils\Wine\WineFilterCriteria;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/{_locale}/wino")
 * @Route("/{_locale}/wine")
 */
class WinePageController extends Controller {
    
    /**
     * @Route("/", name="wine_page_index")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $wineRepo = $em->getRepository('AdminBundle:Wine');

        //get wines
        $wines = $wineRepo->getAll($request->getLocale(), true);
        //get wine colors
        $wineColors = $em->getRepository('AdminBundle:WineColor')->findAll();
        //get wine maturities
        $wineMaturities  = $em->getRepository('AdminBundle:WineMaturity')->findAll();
        //get wine countries
        $wineCountries  = $em->getRepository('AdminBundle:WineCountry')->getAll($request->getLocale());


        //wine page text
        $winePage = $em->getRepository('AdminBundle:CmsStaticPage')->getByParam('wine');

        //wine cart config param
        $cmsConfigWineCart = $this->get('app.config_helper')
            ->getByKey('wine_cart');
        
        //initial params for slider
        $sliderParams = [
            'minYear'  => $wineRepo->getMinYear(),
            'maxYear'  => $wineRepo->getMaxYear(),
            'minPrice' => $wineRepo->getMinPrice(),
            'maxPrice' => $wineRepo->getMaxPrice()
        ];
        
        return $this->render('@App/Wine/wine_page_index.html.twig', [
            'wines'          => $wines,
            'wineColors'     => $wineColors,
            'wineMaturities' => $wineMaturities,
            'wineCountries'  => $wineCountries,
            'sliderParams'   => $sliderParams,
            'winePage'       => $winePage,
            'cmsConfigWineCart' => $cmsConfigWineCart
        ]);
    }

    /**
     * @Route("/filter", name="wine_page_filter", options={"expose": true})
     */
    public function filterAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $filterCriteria = new WineFilterCriteria($em);
        $filterCriteria
            ->setPriceRange($request->get('price-range-min'), $request->get('price-range-max'))
            ->setYearRange($request->get('year-range-min'), $request->get('year-range-max'))
            ->setWineColor($request->get('wineColor'))
            ->setWineCountry($request->get('wineCountry'))
            ->setWineMaturity($request->get('wineMaturity'))
            ;

        $wines = $em->getRepository('AdminBundle:Wine')->getAllByFilterCriteria($filterCriteria, $request->getLocale());

        $responseHtml = $this->renderView('@App/Wine/partials/wine_page_index/wine_list.html.twig', [
            'wines' => $wines
        ]);
        return new Response($responseHtml);
    }




    



}
