<?php

namespace AdminBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use APY\DataGridBundle\Grid\Column\RankColumn;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use APY\DataGridBundle\Grid\Source\Entity as ApyEntity;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/cms_newsletter", defaults={"_locale": "pl"})
 */
class CmsNewsletterController extends Controller
{
    /**
     * @Breadcrumb("cms_newsletter_index", routeName="cms_newsletter_index")
     * @Route("/index", name="cms_newsletter_index")
     */
    public function indexAction(Request $request) {
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('@Admin/CmsNewsletter/cms_newsletter_index.html.twig', [
            'grid' => $grid
        ]);
    }
    
    /**
     * @Route("/export", name="cms_newsletter_export")
     */
    public function exportAction()
    {
        $entityManager = $this
            ->getDoctrine()
            ->getManager()
        ;
        $newsletterMails = $entityManager
            ->getRepository('AdminBundle:CmsNewsletterMail')
            ->findAll()
        ;

        $response = new StreamedResponse(function () use ($newsletterMails, $entityManager) {
            $fileHandler = fopen('php://output', 'r+');
            foreach ($newsletterMails as $mail) {
                fputcsv($fileHandler, $mail->toCsvArray());
                $entityManager->detach($mail);
            }
            fclose($fileHandler);
        });

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename="newsletter_export.csv"');

        return $response;
    }


    protected function getDataGrid(Request $request) {
        $visibleColumns = ['id', 'name', 'email'];
        $grid = $this->get('grid');
        $dgSource = new ApyEntity('AdminBundle:CmsNewsletterMail');
        $grid->setSource($dgSource);

        //Lp
        //$grid->addColumn(new RankColumn(), 0);

        //-------------ROW---ACTIONS------
        $grid->setVisibleColumns($visibleColumns);
        $grid->setColumnsOrder(['id', 'name', 'email'], false);

        $grid->setDefaultPage(1);
        $grid->setLimits(50);
        $grid->hideFilters();
        $grid->setDefaultOrder('id', 'DESC');
        return $grid;
    }


}
