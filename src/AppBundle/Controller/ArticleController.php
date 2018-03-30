<?php

namespace AppBundle\Controller;


use AdminBundle\Form\CmsNewsletterMailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ArticleController extends Controller
{
    /**
     * @Route("{_locale}/aktualnosci/{slug}", name="article_details_news")
     */
    public function detailsAction($slug)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $articleEntity = $entityManager->getRepository('AdminBundle:CmsArticle')->findBySlug($slug);
        if (!$articleEntity) {
            return $this->redirectToRoute('homepage');
        }
        return $this->render('@App/Article/article_details.html.twig', [
            'article' => $articleEntity,
        ]);
    }

    /**
     * @Route("/{_locale}/aktualnosci/lista/1", name="articles_index")
     * @param Request $request
     */
    public function indexAction(Request $request) {
        $page = $request->get('page', 1);
        $em = $this->getDoctrine()->getManager();
        $newsQuery = $em->getRepository('AdminBundle:CmsArticle')->getActive(null, true);

        $paginator = $this->get('knp_paginator');
        $news = $paginator->paginate($newsQuery, $page, 10);
        
        return $this->render('@App/Article/article_index.html.twig', [
            'news' => $news
        ]);
    }





}
