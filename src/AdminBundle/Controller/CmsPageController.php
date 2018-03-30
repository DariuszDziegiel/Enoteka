<?php

namespace AdminBundle\Controller;
use AdminBundle\Entity\CmsCategory;
use AdminBundle\Entity\CmsPage;
use AdminBundle\Form\CmsPageType;
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
 * @Route("/admin/cms_page", defaults={"_locale": "pl"})
 */
class CmsPageController extends Controller
{
    /**
     * @Route("/index/{cmsCategoryId}", name="cms_page_index")
     */
    public function indexAction($cmsCategoryId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cmsCategory = $em->getRepository('AdminBundle:CmsCategory')->find($cmsCategoryId);
        if (!$cmsCategory) {
            return $this->redirectToRoute('admin_default');
        }
        $grid = $this->getDataGrid($cmsCategory, $request);

        //breadcrumb
        $this->get('apy_breadcrumb_trail')->add('Lista podkategorii <b>"' .$cmsCategory->getTitle(). '"</b>' , 'cms_page_index', [
            'cmsCategoryId' => $cmsCategoryId
        ]);

        return $grid->getGridResponse('@Admin/CmsPage/cms_page_index.html.twig', [
            'grid'        => $grid,
            'cmsCategory' => $cmsCategory
        ]);
    }

    /**
     * @Route("/add/{cmsCategoryId}", name="cms_page_add")
     */
    public function addAction($cmsCategoryId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cmsCategory = $em->getRepository('AdminBundle:CmsCategory')->find($cmsCategoryId);
        if (!$cmsCategory) {
            return $this->redirectToRoute('admin_default');
        }

        $recordEntity = new CmsPage();
        $form = $this->createForm(CmsPageType::class, $recordEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                //save category of page
                $recordEntity->setCmsCategory($cmsCategory);
                
                $em->persist($recordEntity);
                $em->flush();
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('cms_page_edit', ['id' => $recordEntity->getId()]);
            } catch (\Exception $e) {
                $this->addFlash('form_error', true);
            }
        }
        
        //breadcrumbs
        $this->get('apy_breadcrumb_trail')->add('Lista podkategorii <b>"' .$cmsCategory->getTitle(). '"</b>' , 'cms_page_index', [
            'cmsCategoryId' => $cmsCategoryId
        ]);
        $this->get('apy_breadcrumb_trail')->add('Dodawanie nowej podkategorii <b>"' .$cmsCategory->getTitle(). '"</b>' , 'cms_page_add', [
            'cmsCategoryId' => $cmsCategoryId
        ]);

        return $this->render('@Admin/CmsPage/cms_page_form.html.twig', [
            'form'       => $form->createView()
        ]);
    }
    
    /**
     * @Route("/{id}/edit", name="cms_page_edit")
     */
    public function editAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        /** @var $recordEntity CmsPage */
        $recordEntity = $em->getRepository('AdminBundle:CmsPage')->find($id);
        if (!$recordEntity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CmsPageType::class, $recordEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            try  {
                $em->flush();
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('cms_page_edit', ['id' => $recordEntity->getId()]);
            } catch (\Exception $e) {
                $this->addFlash('form_error', true);
            }
        }

        //breadcrumbs
        $this->get('apy_breadcrumb_trail')->add('Lista podkategorii <b>"' .$recordEntity->getCmsCategory()->getTitle(). '"</b>' , 'cms_page_index', [
            'cmsCategoryId' => $recordEntity->getCmsCategory()->getId()
        ]);
        $this->get('apy_breadcrumb_trail')->add(
            $recordEntity->getTitle(),
            'cms_page_edit',
            ['id' => $recordEntity->getId()]
        );

        //images
        $images = $em->getRepository('AdminBundle:CmsPageFile')->getFilesByCmsPage($recordEntity);


        return $this->render('@Admin/CmsPage/cms_page_form.html.twig', [
            'form'       => $form->createView(),
            'cmsPage'    => $recordEntity,
            'images'     => $images
        ]);
    }


    /**
     * @Route("/sort/{id}/{direction}", name="cms_page_sort")
     */
    public function setSortAction($id, $direction) {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('AdminBundle:CmsPage');

        /** @var CmsPage $entity */
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
        return $this->redirectToRoute('cms_page_index', ['cmsCategoryId' => $entity->getCmsCategory()->getId()]);
    }




    public function getDataGrid(CmsCategory $cmsCategory, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AdminBundle:CmsPage');
        $maxSort = $repo->getMaxSort($cmsCategory);

        $grid = $this->get('grid');
        $dgSource = new ApyEntity('AdminBundle:CmsPage');

        $qb = $repo->createQueryBuilder('p')
            ->where('p.cmsCategory = :cmsCategory')
            ->setParameter(':cmsCategory', $cmsCategory)
            ->orderBy('p.sort', 'ASC');

        $dgSource->initQueryBuilder($qb);
        $grid->setSource($dgSource);

        //------------------------------Rank column-------------------------
        $rankCol = new RankColumn();
        $grid->addColumn($rankCol);

        //----------SORT column-----------------------------------------------------------------------------
        $sortColumn = new BlankColumn([
            'id'    => 'sort',
            'title' => 'Zmiana kolejności'
        ]);
        $sortColumn->manipulateRenderCell(function($value, Row $row, $router) use ($maxSort) {
            /** @var CmsPage $cmsPage */
            $cmsPage = $row->getEntity();
            echo $this->renderView('@Admin/CmsPage/partials/cms_page_sort_column.html.twig', [
                'cmsPage'     => $cmsPage,
                'maxSort'    => $maxSort
            ]);
        });
        $grid->addColumn($sortColumn, 0);
        
        //Main Image
        $MyColumn = new BlankColumn([
            'id' => 'main_image',
            'title' => 'lbl.main_image'
        ]);
        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $this->renderView('@Admin/_Common/apy/datagrid/grid_image.html.twig', [
                'imageDir'      => 'upload/cms_page/main_image/',
                'imageFilename' => $row->getEntity()->getMainImage()
            ]);
        });
        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 0);
        
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
        $rowAction = new RowAction('record_edit', 'cms_page_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);

        $grid->addRowAction($rowAction);
        $grid->setVisibleColumns(['rank', 'title', 'main_image']);
        $grid->setDefaultPage(1);
        $grid->setLimits(75);
        $grid->hideFilters();       //$grid->setDefaultOrder('id', 'DESC');
        return $grid;
    }

}
