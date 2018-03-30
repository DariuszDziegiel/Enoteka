<?php

namespace RsBundle\Controller;

use APY\DataGridBundle\Grid\Column\RankColumn;
use APY\DataGridBundle\Grid\Row;
use RsBundle\Entity\RsRoom;
use RsBundle\Form\RsRoomType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use APY\DataGridBundle\Grid\Source\Entity as ApyEntity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/rs_room", defaults={"_locale": "pl"})
 */
class RsRoomController extends Controller
{
    /**
     * @Breadcrumb("rs_room_index", routeName="rs_room_index")
     * @Route("/index", name="rs_room_index")
     */
    public function indexAction(Request $request) {
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('RsBundle:RsRoom:rs_room_index.html.twig', array(
            'grid' => $grid
        ));
    }


    /**
     * @Breadcrumb("rs_room_index", routeName="rs_room_index")
     * @Breadcrumb("rs_room_add", routeName="rs_room_add")
     * @Route("/add", name="rs_room_add")
     */
    public function addAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $rsRoomEntity = new RsRoom();

        $form = $this->createForm(RsRoomType::class, $rsRoomEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->getRepository('RsBundle:RsRoom')->save($rsRoomEntity);
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('rs_room_edit', ['id' => $rsRoomEntity->getId()]);
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
            }
        }

        return $this->render('RsBundle:RsRoom:rs_room_form.html.twig', array(
            'form' => $form->createView(),
            'formErrors' => $form->getErrors(true)
        ));
    }


    /**
     * @Breadcrumb("rs_room_index", routeName="rs_room_index")
     * @Route("/{id}/edit", name="rs_room_edit")
     */
    public function editAction($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var RsRoom $rsRoomEntity */
        $rsRoomEntity = $entityManager->getRepository('RsBundle:RsRoom')->find($id);
        if (!$rsRoomEntity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(RsRoomType::class, $rsRoomEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->getRepository('RsBundle:RsRoom')->save($rsRoomEntity, false);
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('rs_room_edit', ['id' => $rsRoomEntity->getId()]);
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
            }
        }

        //room gallery
        $rsRoomImages = $entityManager->getRepository('RsBundle:RsRoomFile')->getFilesByRsRoom($rsRoomEntity, 'img');
        
        
        $this->get("apy_breadcrumb_trail")->add($rsRoomEntity->getTitle(), 'rs_room_edit', ['id' => $rsRoomEntity->getId()]);
        return $this->render('@Rs/RsRoom/rs_room_form.html.twig', array(
            'form'         => $form->createView(),
            'rsRoomEntity' => $rsRoomEntity,
            'formErrors'   => $form->getErrors(true),
            'rsRoomImages' => $rsRoomImages
        ));
    }


    /**
     * @Route("/sort/{id}/{direction}", name="cms_article_sort")
     */
    public function setSortAction($id, $direction) {
        $entityManager = $this->getDoctrine()->getManager();
        $rsRoomRepository = $entityManager->getRepository('RsBundle:RsRoom');

        /** @var RsRoom $rsRoom */
        $rsRoom = $rsRoomRepository->find($id);

        if (!$rsRoom) {
            throw $this->createNotFoundException();
        }

        switch ($direction) {
            case 'up':
                $rsRoom->setSort($rsRoom->getSort() - 1);
                break;
            case 'down':
                $rsRoom->setSort($rsRoom->getSort() + 1);
                break;
            case 'first':
                $rsRoom->setSort(0);
                break;
            case 'last':
                $rsRoom->setSort(-1);
                break;
        }

        $rsRoomRepository->save($rsRoom, false);

        $this->addFlash('sort_success', true);
        return $this->redirectToRoute('rs_room_index');
    }



    public function getDataGrid(Request $request) {
        $rsRoomRepository = $this->getDoctrine()->getRepository('RsBundle:RsRoom');
        $maxSort = $rsRoomRepository->getMaxSort();

        $grid = $this->get('grid');
        $dgSource = new ApyEntity('RsBundle:RsRoom');
        $grid->setSource($dgSource);
        $grid->setDefaultOrder('sort', 'ASC');

        //SORT column
        $sortColumn = new BlankColumn([
            'id'    => 'sort',
            'title' => 'Zmiana kolejności'
        ]);

        $sortColumn->manipulateRenderCell(function($value, Row $row, $router) use ($maxSort) {
            /** @var RsRoom $rsRoom */
            $rsRoom = $row->getEntity();
            echo $this->renderView('@Rs/RsRoom/index/rs_room_sort_column.html.twig', [
                'rsRoom'     => $rsRoom,
                'maxSort'    => $maxSort
            ]);
        });
        $grid->addColumn($sortColumn, 0);

        //Main Image
        $MyColumn = new BlankColumn([
            'id'    => 'mainImage_preview',
            'title' => 'lbl.main_image'
        ]);
        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $this->renderView('@Admin/_Common/apy/datagrid/grid_image.html.twig', [
                'imageDir'      => 'upload/rs_room/main_image/',
                'imageFilename' => $row->getField('mainImage')
            ]);
        });
        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 1);

        //Title
        $MyColumn = new BlankColumn(array(
            'id'    => 'title',
            'title' => 'lbl_title'
        ));
        
        $MyColumn->manipulateRenderCell(function ($value, $row, $router)  {
            echo $this->renderView('@Rs/RsRoom/index/rs_room_grid_title.html.twig', [
                'rsRoomEntity' => $row->getEntity()
            ]);
        });
        $grid->addColumn($MyColumn, 0);

        //-------------ROW---ACTIONS------
        //EDIT
        $rowAction = new RowAction('record_edit', 'rs_room_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);
        $grid->addRowAction($rowAction);

        $grid->setVisibleColumns(['rank', 'mainImage_preview', 'title', 'singleBeds',
            'doubleBeds', 'additionalBeds', 'area']);

        $grid->setDefaultPage(1);
        $grid->setLimits(50);
        $grid->hideFilters();

        return $grid;
    }






    
    
}
