<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\WineCountry;
use AdminBundle\Form\WineCountryType;
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
 * @Route("/admin/wine_country", defaults={"_locale": "pl"})
 */
class WineCountryController extends Controller
{


    /**
     * @Route("/index", name="wine_country_index")
     * @Breadcrumb("wine_country_index", routeName="wine_country_index")
     */
    public function indexAction(Request $request)
    {
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('@Admin/WineCountry/wine_country_index.html.twig', [
            'grid' => $grid
        ]);
    }

    /**
     * @Route("/add", name="wine_country_add")
     * @Breadcrumb("wine_country_add", routeName="wine_country_add")
     */
   public function addAction(Request $request)
   {
       $em = $this->getDoctrine()->getManager();
       $recordEntity = new WineCountry();

       $form = $this->createForm(WineCountryType::class, $recordEntity);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           try  {
               $em->persist($recordEntity);
               $em->flush();
               $this->addFlash('form_success', true);
               return $this->redirectToRoute('wine_country_edit', ['id' => $recordEntity->getId()]);
           } catch (\Exception $e) {
               $this->addFlash('form_error', true);
           }
       }

       return $this->render('@Admin/WineCountry/wine_country_form.html.twig', [
           'form'       => $form->createView()
       ]);
   }


    /**
     * @Route("/{id}/edit", name="wine_country_edit")
     * @Breadcrumb("wine_country_index", routeName="wine_country_index")
     */
   public function editAction($id, Request $request) {
       $em = $this->getDoctrine()->getManager();

       /** @var $recordEntity WineCountry */
       $recordEntity = $em->getRepository('AdminBundle:WineCountry')->find($id);
       if (!$recordEntity) {
           throw $this->createNotFoundException();
       }

       $form = $this->createForm(WineCountryType::class, $recordEntity);
       $form->handleRequest($request);

       if ($form->isSubmitted()) {
           if ($form->isValid()) {
               try  {
                   $em->flush();
                   $this->addFlash('form_success', true);
                   return $this->redirectToRoute('wine_country_edit', ['id' => $recordEntity->getId()]);
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
           'wine_country_edit',
           ['id' => $recordEntity->getId()]
       );

       return $this->render('@Admin/WineCountry/wine_country_form.html.twig', [
           'form'       => $form->createView(),
        ]);
   }
    


    public function getDataGrid(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AdminBundle:WineCountry');
        $maxSort = $repo->getMaxSort();

        $qb = $repo->createQueryBuilder('c')
            ->join('c.translations', 'trans')
            ->where('trans.locale = :locale')
            ->setParameter(':locale', 'pl')
            ->orderBy('trans.title');

        $grid = $this->get('grid');
        $dgSource = new ApyEntity('AdminBundle:WineCountry');
        $dgSource->initQueryBuilder($qb);
        $grid->setSource($dgSource);

        //------------------------------Rank column-------------------------
        $rankCol = new RankColumn();
        $grid->addColumn($rankCol, 1);

        //----------SORT column-----------------------------------------------------------------------------
        $sortColumn = new BlankColumn([
            'id'    => 'sort',
            'title' => 'Zmiana kolejności'
        ]);
        $sortColumn->manipulateRenderCell(function($value, Row $row, $router) use ($maxSort) {
            /** @var WineCountry $wineCountry */
            $wineCountry = $row->getEntity();
            echo $this->renderView('@Admin/WineCountry/partials/wine_country_sort_column.html.twig', [
                'wineCountry'=> $wineCountry,
                'maxSort'    => $maxSort
            ]);
        });
        $grid->addColumn($sortColumn, 0);

        //------------------Title Column--------------------------------------------------------------
        $MyColumn = new BlankColumn(array(
            'id'    => 'title',
            'title' => 'lbl_title'
        ));
        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $row->getEntity()->getTitle();
        });
        $grid->addColumn($MyColumn);


        //-------------ROW---ACTIONS------
        $rowAction = new RowAction('record_edit', 'wine_country_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);

        $grid->addRowAction($rowAction);
        $grid->setVisibleColumns(['rank', 'title']);
        $grid->setDefaultPage(1);
        $grid->setLimits(30);
        $grid->hideFilters();       //$grid->setDefaultOrder('id', 'DESC')
        $grid->setDefaultOrder('sort', 'ASC');
        return $grid;
    }


    /**
     * @Route("/sort/{id}/{direction}", name="wine_country_sort")
     */
    public function setSortAction($id, $direction) {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AdminBundle:WineCountry');

        /** @var WineCountry $entity */
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
        return $this->redirectToRoute('wine_country_index');
    }
}
