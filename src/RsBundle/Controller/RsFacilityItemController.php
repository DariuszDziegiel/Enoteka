<?php

namespace RsBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use APY\DataGridBundle\Grid\Row;
use APY\DataGridBundle\Grid\Source\Entity as ApyEntity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use RsBundle\Entity\RsFacilityItem;
use RsBundle\Form\RsFacilityItemType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/rs_facility_item", defaults={"_locale": "pl"})
 */
class RsFacilityItemController extends Controller
{

    /**
     * @Breadcrumb("rs_facility_item_index", routeName="rs_facility_item_index")
     * @Route("/index", name="rs_facility_item_index")
     */
    public function indexAction(Request $request) {
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('RsBundle:RsFacilityItem:rs_facility_item_index.html.twig', [
            'grid' => $grid
        ]);
    }
    
    /**
     * @Breadcrumb("rs_facility_item_index", routeName="rs_facility_item_index")
     * @Breadcrumb("rs_facility_item_add", routeName="rs_facility_item_add")
     * @Route("/add", name="rs_facility_item_add")
     */
    public function addAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();

        $rsFacilityItemEntity = new RsFacilityItem();
        $form = $this->createForm(RsFacilityItemType::class, $rsFacilityItemEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->getRepository('RsBundle:RsFacilityItem')->save($rsFacilityItemEntity);
                $this->addFlash('form_success', true);
                //go to new record edit
                return $this->redirectToRoute('rs_facility_item_edit', ['id' => $rsFacilityItemEntity->getId()]);
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
            }
        }
        return $this->render('@Rs/RsFacilityItem/rs_facility_item_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    
    /**
     * @Breadcrumb("rs_facility_item_index", routeName="rs_facility_item_index")
     * @Route("/{id}/edit", name="rs_facility_item_edit")
     */
    public function editAction($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        
        /** @var RsFacilityItem $rsFacilityItemEntity */
        $rsFacilityItemEntity = $entityManager->getRepository('RsBundle:RsFacilityItem')->find($id);
        if (!$rsFacilityItemEntity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(RsFacilityItemType::class, $rsFacilityItemEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->getRepository('RsBundle:RsFacilityItem')->save($rsFacilityItemEntity, false);
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('rs_facility_item_edit', ['id' => $rsFacilityItemEntity->getId()]);
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
            }
        }

        $this->get('apy_breadcrumb_trail')->add($rsFacilityItemEntity->getTitle(), 'rs_facility_item_edit', ['id' => $rsFacilityItemEntity->getId()]);
        return $this->render('@Rs/RsFacilityItem/rs_facility_item_form.html.twig', [
            'form' => $form->createView(),
            'rsFacilityItem' => $rsFacilityItemEntity
        ]);
    }


    public function getDataGrid(Request $request) {
        $grid = $this->get('grid');
        $dgSource = new ApyEntity('RsBundle:RsFacilityItem');
        $grid->setSource($dgSource);

        //default icon column
        $MyColumn = new BlankColumn(array(
            'id'    => 'iconDefault_preview',
            'title' => 'lbl.iconDefault'
        ));
        $MyColumn->manipulateRenderCell(function ($value, $row, $router) {
            /**
             * @var $row Row
             * @var $rsFacilityItem RsFacilityItem
             */
            $rsFacilityItem = $row->getEntity();
            return $rsFacilityItem->getIconDefault();
        });
        $grid->addColumn($MyColumn, 0);

        $MyColumn = new BlankColumn(array(
            'id'    => 'title',
            'title' => 'lbl_title'
        ));
        $MyColumn->manipulateRenderCell(function ($value, $row, $router) {
            $rsMealEntity = $this->getDoctrine()
                ->getRepository('RsBundle:RsFacilityItem')
                ->find($row->getField('id'));
            return $rsMealEntity->getTitle();
        });
        $grid->addColumn($MyColumn, 0);




        //ROW ACTIONS------------
        //EDIT
        $rowAction = new RowAction('record_edit', 'rs_facility_item_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);
        $grid->addRowAction($rowAction);

        $grid->setDefaultPage(1);
        $grid->setLimits(50);
        $grid->hideColumns(['id', 'createdAt', 'updatedAt', 'iconDefault']);
        $grid->hideFilters();
        return $grid;
    }




}

