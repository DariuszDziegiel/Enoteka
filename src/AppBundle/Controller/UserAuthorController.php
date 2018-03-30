<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/user")
 */
class UserAuthorController extends Controller
{

    /**
     * @Security("has_role('ROLE_AUTOR')")
     * @Route("/autor/konkursy/aktywne", name="user_author_active_contests")
     */
    public function activeContestsAction() {
        $this->denyAccessUnlessGranted(['ROLE_AUTOR']);
        $em = $this->getDoctrine()->getManager();

        /** Get active author contests */
        $activeArenaContests = $em->getRepository('AdminBundle:ArenaContest')->getActiveByAutor($this->getUser());

        return $this->render('@App/UserAuthor/user_author_active_contests.html.twig', [
            'activeArenaContests'   => $activeArenaContests,
        ]);
    }

    /**
     * @Security("has_role('ROLE_AUTOR')")
     * @Route("/autor/konkursy/zakonczone", name="user_author_finished_contests")
     */
    public function finishedContestsAction() {
        $this->denyAccessUnlessGranted(['ROLE_AUTOR']);
        $em = $this->getDoctrine()->getManager();

        /** Get finished author contests */
        $finishedArenaContests = $em->getRepository('AdminBundle:ArenaContest')->getFinishedByAutor($this->getUser());

        return $this->render('@App/UserAuthor/user_author_finished_contests.html.twig', [
            'finishedArenaContests' => $finishedArenaContests,
        ]);
    }

    
    
    /**
     * @Security("has_role('ROLE_AUTOR')")
     * @Route("/autor/konkursy/wygrane", name="user_author_winner_contests")
     */
    public function winnerContestsAction() {
        $this->denyAccessUnlessGranted(['ROLE_AUTOR']);
        $em = $this->getDoctrine()->getManager();

        /** Get winner author contests */
        $winnerArenaContests = $em->getRepository('AdminBundle:ArenaContest')->getWinnerByAutor($this->getUser());

        return $this->render('@App/UserAuthor/user_author_winner_contests.html.twig', [
            'winnerArenaContests'   => $winnerArenaContests
        ]);
    }

    
    /**
     * @Security("has_role('ROLE_AUTOR')")
     * @Route("/autor/konkurs/{slug}/{hash}/umowa", name="user_author_winner_contract")
     */
    public function contestsAction($slug, $hash) {
        $this->denyAccessUnlessGranted(['ROLE_AUTOR']);
        $em = $this->getDoctrine()->getManager();

        $arenaContest = $em->getRepository('AdminBundle:ArenaContest')->findOneBy([
            'slug' => $slug,
            'hash' => $hash
        ]);

        if (!$arenaContest || $arenaContest->getWinnerAuthor() != $this->getUser()) {
            return $this->redirectToRoute('homepage');
        }
        $mpdfService = $this->get('tfox.mpdfport');

        $author    = $arenaContest->getWinnerAuthor();
        $organizer = $arenaContest->getOrganizer();
        $winnerParticipation = $arenaContest->getWinnerParticipation();
        
        return $response = $mpdfService->generatePdfResponse(
            $this->renderView('@App/UserAuthor/partials/winner_contract/winner_contract_pdf.html.twig', [
                'arenaContest'         => $arenaContest,
                'author'               => $author,
                'winnerParticipation'  => $winnerParticipation,
                'organizer'            => $organizer
            ])
        );
    }










}
