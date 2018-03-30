<?php

namespace AppBundle\Controller;


use AdminBundle\Entity\CmsNewsletterMail;
use AdminBundle\Form\CmsNewsletterMailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/newsletter")
 */
class NewsletterController extends Controller
{
    /**
     * @Route("/add_mail", name="newsletter_mail_add")
     */
    public function addMailAction(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $cmsNewsletterEntity = new CmsNewsletterMail();

        $newsletterAddForm = $this->createForm(CmsNewsletterMailType::class, $cmsNewsletterEntity);
        $newsletterAddForm->handleRequest($request);

        if ($newsletterAddForm->isValid()) {
            $entityManager->getRepository('AdminBundle:CmsNewsletterMail')->save($cmsNewsletterEntity);
            return new JsonResponse([
                'message' => 'Dziękuję za dodanie Twojego adresu email.'
            ], 200);
        }

        $response = new JsonResponse([
            'message' => 'Popraw formularz',
            'form'    => $this->renderView('@App/Newsletter/form/newsletter_mail_add.html.twig', [
                'form' => $newsletterAddForm->createView()
            ])
        ], 400);
        return $response;
    }




}
