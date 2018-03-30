<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\CmsLanguage;
use AdminBundle\Form\CmsLanguageType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Row;
use APY\DataGridBundle\Grid\Source\Entity as ApyEntity;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/cms_language", defaults={"_locale": "pl"})
 */
class CmsLanguageController extends Controller
{
    /**
     * @Breadcrumb("cms_language_index", routeName="cms_language_index")
     * @Route("/index", name="cms_language_index")
     */
    public function indexAction(Request $request)
    {
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('AdminBundle:CmsLanguage:cms_language_index.html.twig', [
            'grid' => $grid
        ]);
    }

    /**
     *  @Breadcrumb("cms_language_index", routeName="cms_language_index")
     *  @Route("/{id}/edit", name="cms_language_edit")
     */
    public function editAction($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var CmsLanguage $cmsLanguage */
        $cmsLanguage = $entityManager->getRepository('AdminBundle:CmsLanguage')->find($id);
        if (!$cmsLanguage) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CmsLanguageType::class, $cmsLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->flush();
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('cms_language_edit', ['id' => $cmsLanguage->getId()]);
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
            }
        }

        $this->get("apy_breadcrumb_trail")->add($cmsLanguage->getTitle(), 'cms_language_edit', ['id' => $cmsLanguage->getId()]);
        return $this->render('@Admin/CmsLanguage/cms_language_form.html.twig', array(
            'form'        => $form->createView(),
            'cmsLanguage' => $cmsLanguage
        ));
    }


    /**
     * @Route("/{languageCode}/download-messages", name="cms_language_download_messages")
     */
    public function getMessagesFileAction($languageCode) {
        $path = $this->get('kernel')->getRootDir().'/../src/AppBundle/Resources/translations/';
        $filename  = 'messages.' .$languageCode. '.yml';
        $filenameDownload = 'messages.' .$languageCode. '.txt';

        $content = file_get_contents($path. $filename);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/plain');
        $response->headers->set('Content-Disposition', 'attachment;filename="'. $filenameDownload);

        $response->setContent($content);
        return $response;
    }
    
    
    /**
     * --- DATA GRID ----
     * @param Request $requestCmsStat
     * @return \APY\DataGridBundle\Grid\Grid
     */
    public function getDataGrid(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $grid = $this->get('grid');
        $dgSource = new ApyEntity('AdminBundle:CmsLanguage');

        $queryBuilder = $em->getRepository('AdminBundle:CmsLanguage')
            ->createQueryBuilder('lang')
            ->where('lang.code != :lang')
            ->setParameter(':lang', 'pl');
        ;

        $dgSource->initQueryBuilder($queryBuilder);
        $grid->setSource($dgSource);



        //Main Image
        $MyColumn = new BlankColumn([
            'id'    => 'mainImage_preview',
            'title' => 'Flaga'
        ]);
        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $this->renderView('@Admin/_Common/apy/datagrid/grid_image.html.twig', [
                'imageDir'      => 'images/flags/',
                'imageFilename' => $row->getField('code'). '.png',
                'imageWidth' => 32
            ]);
        });
        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 1);


        //ROW ACTIONS
        $rowAction = new RowAction('record_edit', 'cms_language_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);
        $grid->addRowAction($rowAction);

        $grid->setDefaultPage(1);
        $grid->setLimits(50);
        $grid->setVisibleColumns(['title', 'mainImage_preview', 'isActive', 'isActiveOnPage']);
        $grid->setDefaultOrder('id', 'ASC');
        $grid->hideFilters();
        return $grid;
    }


}
