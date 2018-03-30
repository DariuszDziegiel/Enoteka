<?php
namespace AppBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/user")
 */
class UserOrganizerController extends Controller
{
    
    /**
     * @Breadcrumb("user_profile_organizer", routeName="user_profile")
     * @Security("has_role('ROLE_ORGANIZER')")
     * @Route("/organizator/konkursy/aktywne", name="user_organizer_active_contests")
     */
    public function activeContestsAction() {
        $this->denyAccessUnlessGranted(['ROLE_ORGANIZER']);

        $em = $this->getDoctrine()->getManager();

        /** Get Active Arena Contests */
        $activeArenaContests = $em->getRepository('AdminBundle:ArenaContest')->getActiveByUser($this->getUser());

        $this->get('apy_breadcrumb_trail')->add('active_contests', 'user_organizer_active_contests');

        return $this->render('@App/UserOrganizer/user_organizer_active_contests.html.twig', [
            'activeArenaContests'   => $activeArenaContests
        ]);
    }

    /**
     * @Breadcrumb("user_profile_organizer", routeName="user_profile")
     * @Security("has_role('ROLE_ORGANIZER')")
     * @Route("/organizator/konkursy/oczekujace", name="user_organizer_waiting_contests")
     */
    public function waitingContestsAction() {
        $this->denyAccessUnlessGranted(['ROLE_ORGANIZER']);

        $em = $this->getDoctrine()->getManager();

        /** get waiting for payment */
        $waitingArenaContests = $em->getRepository('AdminBundle:ArenaContest')->getWaitingByUser(
            $this->getUser(),
            $em->getRepository('AppBundle:PaymentStatus')->getByCode('completed')
        );

        $this->get('apy_breadcrumb_trail')->add('waiting_contests', 'user_organizer_waiting_contests');

        return $this->render('@App/UserOrganizer/user_organizer_waiting_contests.html.twig', [
            'waitingArenaContests'  => $waitingArenaContests
        ]);
    }
    
    /**
     * @Breadcrumb("user_profile_organizer", routeName="user_profile")
     * @Security("has_role('ROLE_ORGANIZER')")
     * @Route("/organizator/konkursy/zakonczone", name="user_organizer_finished_contests")
     */
    public function finishedContestsAction() {
        $this->denyAccessUnlessGranted(['ROLE_ORGANIZER']);

        $em = $this->getDoctrine()->getManager();

        /** Get Finished Arena Contests */
        $finishedArenaContests = $em->getRepository('AdminBundle:ArenaContest')->getFinishedByUser($this->getUser());

        $this->get('apy_breadcrumb_trail')->add('finished_contests', 'user_organizer_finished_contests');

        return $this->render('@App/UserOrganizer/user_organizer_finished_contests.html.twig', [
            'finishedArenaContests' => $finishedArenaContests,
        ]);
    }

}
