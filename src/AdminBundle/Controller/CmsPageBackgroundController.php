<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\CmsConfig;
use AdminBundle\Entity\CmsPageBackground;
use AdminBundle\Form\CmsConfigType;
use AdminBundle\Form\CmsPageBackgroundType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Row;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use APY\DataGridBundle\Grid\Source\Entity as ApyEntity;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Column\RankColumn;
use APY\DataGridBundle\Grid\Action\RowAction;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/cms_page_background", defaults={"_locale": "pl"})
 */
class CmsPageBackgroundController extends Controller
{
    
    /**
     * @Breadcrumb("cms_page_background_index", routeName="cms_page_background_index")
     * @Route("/index", name="cms_page_background_index")
     */
    public function indexAction(Request $request) {
        
        /** @var CmsConfig $cmsConfig */
        $cmsConfig = $this->getDoctrine()->getRepository('AdminBundle:CmsConfig')->find(1);
        if (!$cmsConfig) {
            $cmsConfig = new CmsConfig();
        }
        $form = $this->createForm(CmsConfigType::class, $cmsConfig, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $this->getDoctrine()->getRepository('AdminBundle:CmsConfig')->save($cmsConfig);
                $this->addFlash('form_success', true);
            } catch (\Exception $e) {
                $this->addFlash('form_error', true);
            }
            return $this->redirectToRoute('cms_page_background_index');
        }
        
        
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('AdminBundle:CmsPageBackground:cms_page_background_index.html.twig', [
            'grid' => $grid,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Breadcrumb("cms_page_background_index", routeName="cms_page_background_index")
     * @Breadcrumb("cms_page_background_add", routeName="cms_page_background_add")
     * @Route("/add", name="cms_page_background_add")
     */
    public function addAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $cmsPageBackground = new CmsPageBackground();
        $form = $this->createForm(CmsPageBackgroundType::class, $cmsPageBackground);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $entityManager->getRepository('AdminBundle:CmsPageBackground')->save($cmsPageBackground);
                    $this->addFlash('form_success', true);
                    return $this->redirectToRoute('cms_page_background_edit', ['id' => $cmsPageBackground->getId()]);
                } catch (\Exception $e) {
                    $this->addFlash('form_error', true);
                }
            }
            if (!$form->isValid()) {
                $this->addFlash('form_error', true);
            }
        }
        return $this->render('@Admin/CmsPageBackground/cms_page_background_form.html.twig', [
            'form' => $form->createView()
        ]);
        
    }



    /**
     * @Breadcrumb("cms_page_background_index", routeName="cms_page_background_index")
     * @Route("/{id}/edit", name="cms_page_background_edit")
     */
    public function editAction($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        /** @var CmsPageBackground $cmsPageBackground */
        $cmsPageBackground = $entityManager->getRepository('AdminBundle:CmsPageBackground')->find($id);
        if (!$cmsPageBackground) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CmsPageBackgroundType::class, $cmsPageBackground);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $entityManager->getRepository('AdminBundle:CmsPageBackground')->save($cmsPageBackground);
                    $this->addFlash('form_success', true);
                    return $this->redirectToRoute('cms_page_background_edit', ['id' => $cmsPageBackground->getId()]);
                } catch (\Exception $e) {
                    $this->addFlash('form_error', true);
                }
            }
            if (!$form->isValid()) {
                $this->addFlash('form_error', true);
            }
        }

        $this->get('apy_breadcrumb_trail')->add('cms_page_background_edit', 'cms_page_background_edit', ['id' => $cmsPageBackground->getId()]);
        return $this->render('@Admin/CmsPageBackground/cms_page_background_form.html.twig', [
            'form'              => $form->createView(),
            'cmsPageBackground' => $cmsPageBackground
        ]);

    }


    public function getDataGrid(Request $request)
    {
        $visibleColumns = ['rank', 'imagePreview', 'isActive'];
        $grid = $this->get('grid');
        //$em = $this->getDoctrine()->getManager();

        $dgSource = new ApyEntity('AdminBundle:CmsPageBackground');
        $grid->setSource($dgSource);

        //Lp
        $grid->addColumn(new RankColumn());

        //Main Image
        $MyColumn = new BlankColumn([
            'id'    => 'imagePreview',
            'title' => 'lbl.main_image'
        ]);
        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $this->renderView('@Admin/_Common/apy/datagrid/grid_image.html.twig', [
                'imageDir'      => 'upload/page_background/',
                'imageFilename' => $row->getEntity()->getImage()
            ]);
        });

        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 0);

        //-------------ROW---ACTIONS------
        //EDIT
        $rowAction = new RowAction('record_edit', 'cms_page_background_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);
        $grid->addRowAction($rowAction);

        $grid->setVisibleColumns($visibleColumns);
        $grid->setColumnsOrder(['id', 'rank', 'sort', 'imagePreview', 'isActive'], false);

        $grid->setDefaultPage(1);
        $grid->setLimits(15);
        $grid->hideFilters();
        $grid->setDefaultOrder('sort', 'ASC');
        return $grid;
    }


    
    
}
