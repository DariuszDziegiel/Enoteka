<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\CmsSlider;
use AdminBundle\Form\CmsSliderType;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Row;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\Request;
use APY\DataGridBundle\Grid\Source\Entity as ApyEntity;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Column\RankColumn;
use APY\DataGridBundle\Grid\Action\RowAction;
/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/cms_slider", defaults={"_locale": "pl"})
 */
class CmsSliderController extends Controller
{

    /**
     * @Breadcrumb("cms_slider_index", routeName="cms_slider_index")
     * @Route("/index", name="cms_slider_index")
     */
    public function indexAction(Request $request) {
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('AdminBundle:CmsSlider:cms_slider_index.html.twig', [
            'grid' => $grid
        ]);
    }

    /**
     * @Breadcrumb("cms_slider_index", routeName="cms_slider_index")
     * @Breadcrumb("cms_slider_add", routeName="cms_slider_add")
     * @Route("/add", name="cms_slider_add")
     */
    public function addAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();

        $cmsSliderEntity = new CmsSlider();
        $form = $this->createForm(CmsSliderType::class, $cmsSliderEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $entityManager->getRepository('AdminBundle:CmsSlider')->save($cmsSliderEntity);
                    $this->addFlash('form_success', true);
                    return $this->redirectToRoute('cms_slider_edit', ['id' => $cmsSliderEntity->getId()]);
                } catch (Exception $e) {
                    $this->addFlash('form_error', true);
                }
            }
            if (!$form->isValid()) {
                $this->addFlash('form_error', true);
            }
        }
        
        return $this->render('@Admin/CmsSlider/cms_slider_form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Breadcrumb("cms_slider_index", routeName="cms_slider_index")
     * @Route("/{id}/edit", name="cms_slider_edit")
     */
    public function editAction($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();

        /** @var CmsSlider $cmsSliderEntity */
        $cmsSliderEntity = $entityManager->getRepository('AdminBundle:CmsSlider')->find($id);
        if (!$cmsSliderEntity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CmsSliderType::class, $cmsSliderEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $entityManager->getRepository('AdminBundle:CmsSlider')->save($cmsSliderEntity);
                    $this->addFlash('form_success', true);
                    return $this->redirectToRoute('cms_slider_edit', ['id' => $cmsSliderEntity->getId()]);
                } catch (Exception $e) {
                    $this->addFlash('form_error', true);
                }
            }
            if (!$form->isValid()) {
                $this->addFlash('form_error', true);
            }
        }

        $this->get('apy_breadcrumb_trail')->add('cms_slider_edit', 'cms_slider_edit', ['id' => $cmsSliderEntity->getId()]);
        return $this->render('@Admin/CmsSlider/cms_slider_form.html.twig', [
            'form'      => $form->createView(),
            'cmsSlider' => $cmsSliderEntity
        ]);
    }
    
    /**
     * @Route("/{id}/delete", name="cms_slider_delete")
     */
    public function deleteSlideAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $cmsSlide = $em->getRepository('AdminBundle:CmsSlider')->find($id);

        $fileSystemHelper = $this->get('app.filesystem_helper');
        if ($fileSystemHelper->isFileExists($cmsSlide->getFilesDir(), $cmsSlide->getImage())) {
            try {
                $fileSystemHelper->deleteFile($cmsSlide->getFilesDir(), $cmsSlide->getImage());
                $em->remove($cmsSlide);
                $em->flush();
                $this->addFlash('slide_delete_success', true);
            } catch (IOException $e) {
                $this->addFlash('slide_delete_error', 'msg.image_remove_error');;
            }
        } else {
            $this->addFlash('slide_delete_error', 'msg.image_remove_error');
            $this->addFlash('slide_delete_error', 'msg.file_not_exists');
        }

        return $this->redirectToRoute('cms_slider_index');
    }


    /**
     * DATA GRID
     * @param Request $request
     * @return Grid
     */
    public function getDataGrid(Request $request) 
    {
        $visibleColumns = ['rank', 'imagePreview', 'isActive'];
        $grid = $this->get('grid');
        //$em = $this->getDoctrine()->getManager();

        $dgSource = new ApyEntity('AdminBundle:CmsSlider');
        $grid->setSource($dgSource);

        //Lp.
        $grid->addColumn(new RankColumn());

        //Main Image
        $MyColumn = new BlankColumn([
            'id'    => 'imagePreview',
            'title' => 'lbl.main_image'
        ]);

        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $this->renderView('@Admin/_Common/apy/datagrid/grid_image.html.twig', [
                'imageDir'      => 'upload/cms_slider/',
                'imageFilename' => $row->getEntity()->getImage()
            ]);
        });

        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 0);
        
        //-------------ROW---ACTIONS------
        //EDIT
        $rowAction = new RowAction('record_edit', 'cms_slider_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);
        $grid->addRowAction($rowAction);

        //DELETE
        $rowAction = new RowAction('record_delete', 'cms_slider_delete', false, '_self', ['class' => 'btn btn-danger btn-sm cms-slider-delete-btn']);
        $rowAction->setRouteParameters(['id']);
        $grid->addRowAction($rowAction);


        $grid->setVisibleColumns($visibleColumns);
        $grid->setColumnsOrder(['id', 'rank', 'imagePreview', 'isActive'], false);

        $grid->setDefaultPage(1);
        $grid->setLimits(15);
        $grid->hideFilters();
        $grid->setDefaultOrder('id', 'DESC');
        return $grid;
    }






}
