<?php

namespace RsBundle\Controller;

use APY\DataGridBundle\Grid\Column\RankColumn;
use APY\DataGridBundle\Grid\Row;
use RsBundle\Entity\RsPackage;
use RsBundle\Form\RsPackageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use APY\DataGridBundle\Grid\Source\Entity as ApyEntity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/rs_package", defaults={"_locale": "pl"})
 */
class RsPackageController extends Controller
{
    /**
     * @Breadcrumb("rs_package_index", routeName="rs_package_index")
     * @Route("/index", name="rs_package_index")
     */
    public function indexAction(Request $request) {
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('RsBundle:RsPackage:rs_package_index.html.twig', array(
            'grid' => $grid
        ));
    }

    /**
     * @Breadcrumb("rs_package_index", routeName="rs_package_index")
     * @Breadcrumb("rs_package_add", routeName="rs_package_add")
     * @Route("/add", name="rs_package_add")
     */
    public function addAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $rsPackage = new RsPackage();

        $form = $this->createForm(RsPackageType::class, $rsPackage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->persist($rsPackage);
                $entityManager->flush();
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('rs_package_edit', ['id' => $rsPackage->getId()]);
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
            }
        }

        return $this->render('@Rs/RsPackage/rs_package_form.html.twig', array(
            'form' => $form->createView(),
            'formErrors' => $form->getErrors(true)
        ));
    }

    /**
     * @Breadcrumb("rs_package_index", routeName="rs_package_index")
     * @Route("/{id}/edit", name="rs_package_edit")
     */
    public function editAction($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var RsPackage $rsPackage */
        $rsPackage = $entityManager->getRepository('RsBundle:RsPackage')->find($id);
        if (!$rsPackage) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(RsPackageType::class, $rsPackage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->flush();
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('rs_package_edit', ['id' => $rsPackage->getId()]);
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
            }
        }

        $this->get("apy_breadcrumb_trail")->add($rsPackage->getTitle(), 'rs_package_edit', ['id' => $rsPackage->getId()]);
        return $this->render('@Rs/RsPackage/rs_package_form.html.twig', array(
            'form'         => $form->createView(),
            'rsPackage'    => $rsPackage,
            'formErrors'   => $form->getErrors(true)
        ));
    }

    /**
     * @Route("/{id}/remove", name="rs_package_remove")
     */
    public function removeAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $rsPackage = $em->getRepository('RsBundle:RsPackage')->find($id);
        if (!$rsPackage) {
            throw $this->createNotFoundException('Brak wybranego pakietu w bazie danych');
        }
        $em->remove($rsPackage);
        $em->flush();
        $this->addFlash('remove_success', true);
        return $this->redirectToRoute('rs_package_index');
    }
    

    /**
     * @Route("/sort/{id}/{direction}", name="rs_package_sort")
     */
    public function setSortAction($id, $direction) {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('RsBundle:RsPackage');

        /** @var RsPackage $entity */
        $entity = $repository->find($id);

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
        return $this->redirectToRoute('rs_package_index');
    }


    public function getDataGrid(Request $request) {
        $repository = $this->getDoctrine()->getRepository('RsBundle:RsPackage');
        $maxSort = $repository->getMaxSort();

        $grid = $this->get('grid');
        $dgSource = new ApyEntity('RsBundle:RsPackage');
        $grid->setSource($dgSource);

        //rank column------------------------------------------------------------------------------
        $grid->addColumn(new RankColumn());

        //SORT column-----------------------------------------------------------------------------
        $sortColumn = new BlankColumn([
            'id'    => 'sort',
            'title' => 'Zmiana kolejności'
        ]);
        $sortColumn->manipulateRenderCell(function($value, Row $row, $router) use ($maxSort) {
            /** @var RsPackage $rsPackage */
            $rsPackage = $row->getEntity();
            echo $this->renderView('@Rs/RsPackage/index/rs_package_sort_column.html.twig', [
                'rsPackage'     => $rsPackage,
                'maxSort'    => $maxSort
            ]);
        });
        $grid->addColumn($sortColumn, 0);

        //Main Image-------------------------------------------------------------------------
        $MyColumn = new BlankColumn([
            'id'    => 'mainImage_preview',
            'title' => 'lbl.main_image'
        ]);

        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $this->renderView('@Admin/_Common/apy/datagrid/grid_image.html.twig', [
                'imageDir'      => 'upload/rs_package/main_image/',
                'imageFilename' => $row->getField('mainImage')
            ]);
        });
        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 1);

        //Title------------------------------------------------------------------------------
        $MyColumn = new BlankColumn(array(
            'id'    => 'title',
            'title' => 'lbl_title'
        ));
        $MyColumn->manipulateRenderCell(function ($value, $row, $router)  {
            /** @var $rsPackage RsPackage */
            $rsPackage = $row->getEntity();
            echo $rsPackage->getTitle();
        });
        $grid->addColumn($MyColumn, 0);


        //-------------ROW---ACTIONS------
        //EDIT
        $rowAction = new RowAction('record_edit', 'rs_package_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);
        $grid->addRowAction($rowAction);

        $removeRowAction = new RowAction('record_delete', 'rs_package_remove', false, '_self', ['class' => 'btn btn-danger btn-sm btn-remove']);
        $grid->addRowAction($removeRowAction);

        $grid->setVisibleColumns(['rank', 'mainImage_preview', 'title', 'price', 'isActive']);
        $grid->setDefaultPage(1);
        $grid->setLimits(50);
        $grid->hideFilters();
        $grid->setDefaultOrder('sort', 'ASC');
        return $grid;
    }








}
