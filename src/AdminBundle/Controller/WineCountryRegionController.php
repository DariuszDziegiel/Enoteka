<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\WineCountry;
use AdminBundle\Entity\WineCountryRegion;
use AdminBundle\Form\WineCountryRegionType;
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
 * @Route("/admin/wine_country_region", defaults={"_locale": "pl"})
 */
class WineCountryRegionController extends Controller
{


    /**
     * @Route("/index/{country}", name="wine_country_region_index", defaults={"country": "polska"})
     * @Breadcrumb("wine_country_region_index", routeName="wine_country_region_index")
     */
    public function indexAction($country, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //all countries
        $wineCountries = $em->getRepository('AdminBundle:WineCountry')->getAll();
        //selected country
        $wineCountry = $em->getRepository('AdminBundle:WineCountry')->getBySlug($country);

        $grid = $this->getDataGrid($wineCountry , $request);
        return $grid->getGridResponse('@Admin/WineCountryRegion/wine_country_region_index.html.twig', [
            'grid'          => $grid,
            'wineCountries' => $wineCountries,
            'wineCountrySelected'   => $wineCountry
        ]);
    }

    /**
     * @Route("/add", name="wine_country_region_add")
     * @Breadcrumb("wine_country_region_index", routeName="wine_country_region_index")
     * @Breadcrumb("wine_country_region_add", routeName="wine_country_region_add")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recordEntity = new WineCountryRegion();

        $form = $this->createForm(WineCountryRegionType::class, $recordEntity, [
            'wineCountryRepo' => $em->getRepository('AdminBundle:WineCountry')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {
            try  {
                $em->persist($recordEntity);
                $em->flush();
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('wine_country_region_edit', ['id' => $recordEntity->getId()]);
            } catch (\Exception $e) {
                $this->addFlash('form_error', true);
            }
        }

        return $this->render('@Admin/WineCountryRegion/wine_country_region_form.html.twig', [
            'form'       => $form->createView()
        ]);
    }


    /**
     * @Route("/{id}/edit", name="wine_country_region_edit")
     * @Breadcrumb("wine_country_region_index", routeName="wine_country_region_index")
     */
    public function editAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        /** @var $recordEntity WineCountry */
        $recordEntity = $em->getRepository('AdminBundle:WineCountryRegion')->find($id);
        if (!$recordEntity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(WineCountryRegionType::class, $recordEntity, [
            'wineCountryRepo' => $em->getRepository('AdminBundle:WineCountry')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $em->flush();
                return $this->redirectToRoute('wine_country_region_edit', ['id' => $recordEntity->getId()]);
            } catch (\Exception $e) {
                $this->addFlash('form_error', true);
            }
        }

        $this->get('apy_breadcrumb_trail')->add(
            $recordEntity->getTitle(),
            'wine_country_region_edit',
            ['id' => $recordEntity->getId()]
        );

        return $this->render('@Admin/WineCountryRegion/wine_country_region_form.html.twig', [
            'form'       => $form->createView(),
        ]);
    }



    public function getDataGrid(WineCountry $wineCountry, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo  = $em->getRepository('AdminBundle:WineCountryRegion');

        $grid = $this->get('grid');
        $dgSource = new ApyEntity('AdminBundle:WineCountryRegion');

        $qb = $repo->createQueryBuilder('cr')
            ->where('cr.wineCountry = :wineCountry')
            ->join('cr.translations', 'trans')
            ->setParameter(':wineCountry', $wineCountry)
            ->orderBy('trans.title')
        ;

        $dgSource->initQueryBuilder($qb);
        $grid->setSource($dgSource);

        //------------------------------Rank column-------------------------
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
        $grid->addColumn($MyColumn);


        //-------------ROW---ACTIONS------
        $rowAction = new RowAction('record_edit', 'wine_country_region_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);

        $grid->addRowAction($rowAction);
        $grid->setVisibleColumns(['rank', 'title']);
        $grid->setDefaultPage(1);
        $grid->setLimits(30);
        $grid->hideFilters();       //$grid->setDefaultOrder('id', 'DESC');
        return $grid;
    }

}
