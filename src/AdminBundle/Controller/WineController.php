<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Wine;
use AdminBundle\Entity\WineCountry;
use AdminBundle\Form\WineCountryType;
use AdminBundle\Form\WineType;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Row;
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
 * @Route("/admin/wine", defaults={"_locale": "pl"})
 */
class WineController extends Controller
{


    /**
     * @Route("/index", name="wine_index")
     * @Breadcrumb("wine_index", routeName="wine_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $wines = $em->getRepository('AdminBundle:Wine')->getAll();
        return $this->render('@Admin/Wine/wine_index.html.twig', [
            'wines' => $wines
        ]);
    }

    /**
     * @Route("/add", name="wine_add")
     * @Breadcrumb("wine_add", routeName="wine_add")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recordEntity = new Wine();
        
        $form = $this->createForm(WineType::class, $recordEntity);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try  {
                    $em->persist($recordEntity);
                    $em->flush();
                    $this->addFlash('form_success', true);
                    return $this->redirectToRoute('wine_edit', ['id' => $recordEntity->getId()]);
                } catch (\Exception $e) {
                    $this->addFlash('form_error', true);
                }
            }
            if (!$form->isValid()) {
                $this->addFlash('form_error', true);
            }
        }

        return $this->render('@Admin/Wine/wine_form.html.twig', [
            'form'       => $form->createView()
        ]);
    }


    /**
     * @Route("/{id}/edit", name="wine_edit")
     * @Breadcrumb("wine_index", routeName="wine_index")
     */
    public function editAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        /** @var $recordEntity Wine */
        $recordEntity = $em->getRepository('AdminBundle:Wine')->find($id);
        if (!$recordEntity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(WineType::class, $recordEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try  {
                    $em->flush();
                    $this->addFlash('form_success', true);
                    return $this->redirectToRoute('wine_edit', ['id' => $recordEntity->getId()]);
                } catch (\Exception $e) {
                    $this->addFlash('form_error', true);
                }
            }
            if (!$form->isValid()) {
                $this->addFlash('form_error', true);
            }
        }

        $this->get('apy_breadcrumb_trail')->add(
            $recordEntity->getTitle(),
            'wine_edit',
            ['id' => $recordEntity->getId()]
        );

        return $this->render('@Admin/Wine/wine_form.html.twig', [
            'form'       => $form->createView(),
        ]);
    }


    public function getDataGrid(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $grid = $this->get('grid');
        $dgSource = new ApyEntity('AdminBundle:Wine');
        //$dgSource->initQueryBuilder($qb);
        $grid->setSource($dgSource);


        //------------------------------Rank column-------------------------
        $rankCol = new RankColumn();
        $grid->addColumn($rankCol);

        //------------------Title Column--------------------------------------------------------------
        $MyColumn = new BlankColumn(array(
            'id'    => 'title',
            'title' => 'lbl_title'
        ));
        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $row->getEntity()->getTitle();
        });
        $grid->addColumn($MyColumn);

        //Country column
        $col = new BlankColumn([
            'id'    => 'wine_country',
            'title' => 'Kraj'
        ]);
        $col->manipulateRenderCell(function ($value, Row $row, $router) {
            /** @var Wine $entity */
            $entity = $row->getEntity();
            echo $entity->getWineCountry()->getTitle();
        });
        $grid->addColumn($col);

        //Color column
        $col = new BlankColumn([
            'id'    => 'wine_color',
            'title' => 'Kolor'
        ]);
        $col->manipulateRenderCell(function ($value, Row $row, $router) {
            /** @var Wine $entity */
            $entity = $row->getEntity();
            echo $entity->getWineColor()->getTitle();
        });
        $grid->addColumn($col);
        
        // maturity column
        $col = new BlankColumn([
            'id'    => 'wine_color',
            'title' => 'Wytrawność'
        ]);
        $col->manipulateRenderCell(function ($value, Row $row, $router) {
            /** @var Wine $entity */
            $entity = $row->getEntity();
            echo $entity->getWineMaturity()->getTitle();
        });
        $grid->addColumn($col);

        //-------------ROW---ACTIONS------
        $rowAction = new RowAction('record_edit', 'wine_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);

        $grid->addRowAction($rowAction);
        $grid->setVisibleColumns(['rank', 'year', 'price', 'title', 'wine_country', 'wine_color', 'wine_maturity']);
        $grid->setDefaultPage(1);
        $grid->setLimits(75);
        $grid->hideFilters();       //$grid->setDefaultOrder('id', 'DESC');
        return $grid;
    }

}
