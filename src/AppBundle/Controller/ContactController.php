<?php

namespace AppBundle\Controller;

use AppBundle\Form\ContactForm;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller {
    
    /**
     * @Route("{_locale}/s/kontakt", name="contact")
     * @Route("{_locale}/s/contact", name="contact")
     */
    public function contactPageAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
 
        $cmsStaticPageRepository = $em->getRepository('AdminBundle:CmsStaticPage');

        $cmsStaticPage = $cmsStaticPageRepository
            ->getByParam('contact');

        $form = $this->createForm(ContactForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->addFlash('form_submitted', true);
            if ($form->isValid()) {
                
                if ($this->sendContactMail($form->getData())) {
                    $this->addFlash('mail_send_success', true);
                    return $this->redirectToRoute('contact');
                }
            }
        }

        return $this->render('@App/Contact/contact.html.twig', [
            'cmsStaticPage' => $cmsStaticPage,
            'form'          => $form->createView(),
        ]);
    }


    /**
     * @param FormView $form
     */
    private function sendContactMail($data) {
        $message = new \Swift_Message();
        $message->setContentType('text/html');

        /** Mail Content */
        $message->setSubject('[KONTAKT] - Enoteka Pergamin - '. $data['subject']);
        $message->setBody(
            $this->renderView('@App/Contact/partials/contact_mail.html.twig', $data)
        );

        $message->setFrom(
            $this->getParameter('mailer_from_mail'),
            $this->getParameter('mailer_from_name')
        );
        
        $message->setReplyTo($data['email'], $data['name']);
        $message->setTo($this->getParameter('contact_form_mail'));
        
        return $this->get('swiftmailer.mailer.real_mailer')->send($message);
    }

}