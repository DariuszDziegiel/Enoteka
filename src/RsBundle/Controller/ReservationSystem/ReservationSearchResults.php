<?php
namespace RsBundle\Controller\ReservationSystem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;




/**
 * @Route("/reservation", defaults={"_locale": "pl"})
 */
class ReservationSearchResults extends Controller
{


    /**
     * @Route("/search_results", name="reservation_search_results")
     */
    public function searchResultsAction(Request $request) {

    }



}

