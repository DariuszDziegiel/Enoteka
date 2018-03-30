<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\ArenaContest;
use AdminBundle\Entity\ArenaPackage2ArenaPackageExtra;
use AdminBundle\Entity\ArenaPackageExtra;
use AdminBundle\Entity\ArenaPackagePrice;
use AdminBundle\Entity\CmsCategory;
use AdminBundle\Entity\User;
use AdminBundle\Entity\UserProfile;
use AdminBundle\Entity\WineMaturity;
use AppBundle\Utils\ArenaContest\ArenaContestManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/test")
 * Class TestController
 */
class TestController extends Controller
{

    /**
     * @Route("/test")
     */
    public function testAction() {
        $em = $this->getDoctrine()->getManager();
        return $this->render('@App/Test/test.html.twig');
    }



    /**
     * @Route("/tree")
     * @return Response
     */
    public function treeAction() {
        die;
        $em = $this->getDoctrine()->getManager();
        $cat = new CmsCategory();
        $cat->translate('pl')->setTitle('Rezerwacje');
        $cat->translate('en')->setTitle('Reservations');
        $em->persist($cat);
        $cat->mergeNewTranslations();
        $em->flush();
        return $this->render('@App/Test/test.html.twig');
    }


    /**
     * @Route("/mail")
     */
    public function mailAction() {
    die;

        //echo $this->get('translator')->trans('mail.registration_activation_subject');

        $message = new \Swift_Message();
        $message->setContentType('text/html');

        /** Mail Content */
        $message->setSubject('[KONTAKT] - Home ApartHotel');
        $message->setBody('test mail');

        $message->setFrom(
            $this->getParameter('mailer_from_mail'),
            $this->getParameter('mailer_from_name')
        );

        $message->setReplyTo($this->getParameter('mailer_from_mail'));
        $message->setTo($this->getParameter('contact_form_mail'));

        return $this->get('swiftmailer.mailer.real_mailer')->send($message);
    }

}
