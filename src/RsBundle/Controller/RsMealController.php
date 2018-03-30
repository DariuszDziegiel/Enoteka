<?php

namespace RsBundle\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use APY\DataGridBundle\Grid\Source\Entity as ApyEntity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use RsBundle\Entity\RsMeal;
use RsBundle\Form\RsMealType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/rs_meal", defaults={"_locale": "pl"})
 */
class RsMealController extends Controller
{

    /**
     * @Breadcrumb("rs_meal_index", routeName="rs_meal_index")
     * @Route("/index", name="rs_meal_index")
     */
    public function indexAction(Request $request) {
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('RsBundle:RsMeal:rs_meal_index.html.twig', [
            'grid' => $grid
        ]);
    }
    

    /**
     * @Breadcrumb("rs_meal_index", routeName="rs_meal_index")
     * @Breadcrumb("rs_meal_add", routeName="rs_meal_add")
     * @Route("/add", name="rs_meal_add")
     */
    public function addAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();

        $rsMealEntity = new RsMeal();
        $form = $this->createForm(RsMealType::class, $rsMealEntity);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->getRepository('RsBundle:RsMeal')->save($rsMealEntity);
                $this->addFlash('form_success', true);
                //go to new record edit
                return $this->redirectToRoute('rs_meal_edit', ['id' => $rsMealEntity->getId()]);
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
            }
        }
        return $this->render('@Rs/RsMeal/rs_meal_form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Breadcrumb("rs_meal_index", routeName="rs_meal_index")
     * @Route("/{id}/edit", name="rs_meal_edit")
     */
    public function editAction($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var RsMeal $rsMealEntity */
        $rsMealEntity = $entityManager->getRepository('RsBundle:RsMeal')->find($id);
        if (!$rsMealEntity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(RsMealType::class, $rsMealEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->getRepository('RsBundle:RsMeal')->save($rsMealEntity, false);
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('rs_meal_edit', ['id' => $rsMealEntity->getId()]);
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
            }
        }

        $this->get('apy_breadcrumb_trail')->add($rsMealEntity->getTitle(), 'rs_meal_edit', ['id' => $rsMealEntity->getId()]);
        return $this->render('@Rs/RsMeal/rs_meal_form.html.twig', [
            'form' => $form->createView(),
            'rsMealEntity'     => $rsMealEntity
        ]);
    }


    public function getDataGrid(Request $request) {
        $grid = $this->get('grid');
        $dgSource = new ApyEntity('RsBundle:RsMeal');
        $grid->setSource($dgSource);

        $MyColumn = new BlankColumn(array(
            'id'    => 'title',
            'title' => 'lbl_title'
        ));
        $MyColumn->manipulateRenderCell(function ($value, $row, $router) {
            $rsMealEntity = $this->getDoctrine()
                ->getRepository('RsBundle:RsMeal')
                ->find($row->getField('id'));
            return $rsMealEntity->getTitle();
        });
        $grid->addColumn($MyColumn, 0);

        //ROW ACTIONS------------
        //EDIT
        $rowAction = new RowAction('record_edit', 'rs_meal_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);
        $grid->addRowAction($rowAction);

        $grid->setDefaultPage(1);
        $grid->setLimits(50);
        $grid->hideColumns(['id', 'createdAt', 'updatedAt']);
        $grid->hideFilters();
        return $grid;
    }




}
