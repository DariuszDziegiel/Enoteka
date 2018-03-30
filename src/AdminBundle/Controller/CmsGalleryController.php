<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\CmsGallery;
use AdminBundle\Form\CmsGalleryType;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Row;
use Doctrine\ORM\Query\Expr;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use APY\DataGridBundle\Grid\Source\Entity as ApyEntity;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Column\RankColumn;
use APY\DataGridBundle\Grid\Action\RowAction;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/cms_gallery", defaults={"_locale": "pl"})
 */
class CmsGalleryController extends Controller
{

    /**
     * @Route("/index", name="cms_gallery_index")
     * @Breadcrumb("cms_gallery_index", routeName="cms_gallery_index")
     */
    public function indexAction(Request $request) {
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('AdminBundle:CmsGallery:cms_gallery_index.html.twig', [
            'grid' => $grid
        ]);
    }

    /**
     * @Route("/add", name="cms_gallery_add")
     * @Breadcrumb("cms_gallery_add", routeName="cms_gallery_add")
     */
    public function addAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $cmsGallery = new CmsGallery();
        $form = $this->createForm(CmsGalleryType::class, $cmsGallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->persist($cmsGallery);
                $entityManager->flush();
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('cms_gallery_edit', ['id' => $cmsGallery->getId()]);
            } catch (\Exception $e) {
                echo $e->getMessage();
                $this->addFlash('form_error', true);
            }
        }
        return $this->render('@Admin/CmsGallery/cms_gallery_form.html.twig', [
            'form'       => $form->createView(),
            'formErrors' => $form->getErrors()
        ]);
    }


    /**
     * @Route("/{id}/edit", name="cms_gallery_edit")
     * @Breadcrumb("cms_gallery_index", routeName="cms_gallery_index")
     */
    public function editAction($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();

        /** @var CmsGallery $cmsGallery */
        $cmsGallery = $entityManager->getRepository('AdminBundle:CmsGallery')->find($id);
        if (!$cmsGallery) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CmsGalleryType::class, $cmsGallery);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try  {
                    $entityManager->flush();
                    $this->addFlash('form_success', true);
                    return $this->redirectToRoute('cms_gallery_edit', ['id' => $cmsGallery->getId()]);
                } catch (\Exception $e) {
                    $this->addFlash('form_error', true);
                }
            }
            if (!$form->isValid()) {
                $this->addFlash('form_error', true);
            }
        }

        $this->get('apy_breadcrumb_trail')->add(
            $cmsGallery->getTitle(),
            'cms_gallery_edit',
            ['id' => $cmsGallery->getId()]
        );

        $cmsGalleryImages = $entityManager->getRepository('AdminBundle:CmsGalleryFile')->getFilesByCmsGallery($cmsGallery);

        return $this->render('@Admin/CmsGallery/cms_gallery_form.html.twig', [
            'form'             => $form->createView(),
            'formErrors'       => $form->getErrors(),
            'cmsGallery'       => $cmsGallery,
            'cmsGalleryImages' => $cmsGalleryImages
        ]);
    }

    
    /**
     * @Route("/sort/{id}/{direction}", name="cms_gallery_sort")
     */
    public function setSortAction($id, $direction) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityRepo = $entityManager->getRepository('AdminBundle:CmsGallery');

        /** @var CmsGallery $cmsGallery */
        $entity = $entityRepo->find($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        switch ($direction) {
            case 'up':
                $entity->setSort($entity->getSort() - 1);
                break;
            case 'down':
                $entity->setSort($entity->getSort() + 1);
                break;
            case 'first':
                $entity->setSort(0);
                break;
            case 'last':
                $entity->setSort(-1);
                break;
        }
        $entityManager->flush();

        $this->addFlash('sort_success', true);
        return $this->redirectToRoute('cms_gallery_index');
    }


    
    
    
    
    public function getDataGrid(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $cmsGalleryRepository = $em->getRepository('AdminBundle:CmsGallery');
        $maxSort = $cmsGalleryRepository->getMaxSort();

        $grid = $this->get('grid');
        $dgSource = new ApyEntity('AdminBundle:CmsGallery');
        //$dgSource->initQueryBuilder($qb);
        $grid->setSource($dgSource);
        $grid->setDefaultOrder('sort', 'ASC');


        //------------------------------rank column-------------------------
        $rankCol = new RankColumn();
        $grid->addColumn($rankCol, 1);

        //------------------Title Column--------------------------------------------------------------
        $MyColumn = new BlankColumn(array(
            'id'    => 'title',
            'title' => 'lbl_title'
        ));
        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $row->getEntity()->getTitle();
        });
        $grid->addColumn($MyColumn, 2);

        //------------------------SORT column----------------------------------------------------------
        $sortColumn = new BlankColumn(['id'    => 'sort_change', 'title' => 'Zmiana kolejności']);
        $sortColumn->manipulateRenderCell(function($value, Row $row, $router) use ($maxSort) {
            /** @var CmsGallery $cmsGallery */
            $cmsGallery = $row->getEntity();
            echo $this->renderView('@Admin/CmsGallery/index/cms_gallery_sort_column.html.twig', [
                'cmsGallery'     => $cmsGallery,
                'maxSort'        => $maxSort
            ]);
        });
        $grid->addColumn($sortColumn, 3);

        //----------------Main Image----------------------------------------------------------
        $MyColumn = new BlankColumn([
            'id' => 'main_image',
            'title' => 'lbl.main_image'
        ]);
        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $this->renderView('@Admin/_Common/apy/datagrid/grid_image.html.twig', [
                'imageDir'      => 'upload/cms_gallery/main_image/',
                'imageFilename' => $row->getEntity()->getMainImage()
            ]);
        });
        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 4);

        //------------------Image counter--------------------------------------------------------
        $imgCounterCol = new BlankColumn(['id' => 'images_counter', 'title' => 'L. zdjęć']);
        $imgCounterCol->manipulateRenderCell(function($value, Row $row, $router) {
            /** @var CmsGallery $cmsGallery */
            $cmsGallery = $row->getEntity();
            echo '<span class="badge">'. $cmsGallery->getImages()->count(). '</span>';
        });
        $grid->addColumn($imgCounterCol, 5);

        //Gallery preview
        $galleryPreviewCol = new BlankColumn(['id' => 'images_preview', 'title' => 'Zdjęcia']);
        $galleryPreviewCol->setSize(600);
        $galleryPreviewCol->manipulateRenderCell(function($value, Row $row, $router) use ($em) {
            /** @var CmsGallery $cmsGallery */
            $cmsGallery = $row->getEntity();
            $images = $em->getRepository('AdminBundle:CmsGalleryFile')->getFilesByCmsGallery($cmsGallery);
            echo $this->renderView('@Admin/CmsGallery/index/cms_gallery_preview.html.twig', [
                'images'     => $images,
                'cmsGallery' => $cmsGallery
            ]);
        });
        $grid->addColumn($galleryPreviewCol);
        
        //-------------ROW---ACTIONS------
        //EDIT
        $rowAction = new RowAction('record_edit', 'cms_gallery_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);
        $grid->addRowAction($rowAction);
        $grid->setVisibleColumns(['sort_change', 'rank', 'title', 'images_counter', 'images_preview', 'isActive']);
        $grid->setDefaultPage(1);
        $grid->setLimits(30);
        $grid->hideFilters();       //$grid->setDefaultOrder('id', 'DESC');
        return $grid;
    }




}
