<?php
namespace AppBundle\Controller;

use RsBundle\Entity\RsRoom;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/{_locale}/pokoje")
 * @Route("/{_locale}/rooms")
 */
class RoomsController extends Controller {

    /**
     * @Route("/", name="rooms_index")
     */
    public function indexAction($category = null) {
        $em = $this->getDoctrine()->getManager();
        
        $rsRooms = $em->getRepository('RsBundle:RsRoom')->getActive();
        $rsFacilityItems = $em->getRepository('RsBundle:RsFacilityItem')->findAll();

        return $this->render('@App/Rooms/rooms_index.html.twig', [
            'rsRooms'         => $rsRooms,
            'rsFacilityItems' => $rsFacilityItems
        ]);
    }
    
    /**
     * @Route("/{slug}", name="rooms_details")
     */
    public function detailsAction($slug) {
        $em = $this->getDoctrine()->getManager();
        /** @var RsRoom $rsRoom */
        $rsRoom = $em->getRepository('RsBundle:RsRoom')->getBySlug($slug);

        if (!$rsRoom) {
            return $this->redirectToRoute('homepage');
        }
        //room facilities
        $rsFacilityItems = $rsRoom->getFacilityItems();
        
        //room gallery files
        $rsRoomImages = $em->getRepository('RsBundle:RsRoomFile')->getFilesByRsRoom($rsRoom, 'img');

        return $this->render('@App/Rooms/rooms_details.html.twig', [
            'rsRoom'          => $rsRoom,
            'rsFacilityItems' => $rsFacilityItems,
            'rsRoomImages'    => $rsRoomImages
        ]);
    }
    
    




}