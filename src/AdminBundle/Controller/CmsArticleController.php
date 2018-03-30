<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\CmsArticle;
use AdminBundle\Entity\CmsArticleCategory;
use AdminBundle\Form\CmsArticleType;
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
 * @Route("/admin/cms_article", defaults={"_locale": "pl"})
 */
class CmsArticleController extends Controller
{
    protected $categories;

    public function __construct()
    {
        $this->categories = ['news', 'events', 'articles'];
    }

    /**
     * @Route("/index", name="admin_cms_article_index")
     * @Breadcrumb("admin_cms_article_index", routeName="admin_cms_article_index")
     */
    public function indexAction(Request $request) {
        $grid = $this->getDataGrid($request);

        /*$translator = $this->get('translator');
        $this->get('apy_breadcrumb_trail')->add(
            $translator->trans('admin_cms_article_' .$category. '_index'),
            'admin_cms_article_index',
            ['category' => $category]
        );
        */
        return $grid->getGridResponse('AdminBundle:CmsArticle:cms_article_index.html.twig', [
            'grid' => $grid
        ]);
    }

    /**
     * @Route("/add", name="admin_cms_article_add")
     * @Breadcrumb("admin_cms_article_index", routeName="admin_cms_article_index")
     * @Breadcrumb("admin_cms_article_add", routeName="admin_cms_article_add")
     */
    public function addAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $cmsArticleEntity = new CmsArticle();
        
        $form = $this->createForm(CmsArticleType::class, $cmsArticleEntity);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->persist($cmsArticleEntity);
                $entityManager->flush();
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('admin_cms_article_edit', ['id' => $cmsArticleEntity->getId()]);
            } catch (\Exception $e) {
                //dump($e->getMessage());
                $this->addFlash('form_error', true);
            }
        }
        return $this->render('@Admin/CmsArticle/cms_article_form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/{id}/edit", name="admin_cms_article_edit")
     * @Breadcrumb("admin_cms_article_index", routeName="admin_cms_article_index")
     */
    public function editAction($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var CmsArticle $cmsArticleEntity */
        $cmsArticleEntity = $entityManager->getRepository('AdminBundle:CmsArticle')->find($id);
        if (!$cmsArticleEntity) {
            throw $this->createNotFoundException();
        }


        $form = $this->createForm(CmsArticleType::class, $cmsArticleEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try  {
                    $entityManager->flush();
                    $this->addFlash('form_success', true);
                    return $this->redirectToRoute('admin_cms_article_edit', ['id' => $cmsArticleEntity->getId()]);
                } catch (\Exception $e) {
                    $this->addFlash('form_error', true);
                }
            }
            if (!$form->isValid()) {
                $this->addFlash('form_error', true);
            }
        }

        $this->get('apy_breadcrumb_trail')->add(
            $cmsArticleEntity->getTitle(),
            'admin_cms_article_edit',
            ['id' => $cmsArticleEntity->getId()]
        );

        return $this->render('@Admin/CmsArticle/cms_article_form.html.twig', [
            'form' => $form->createView(),
            'cmsArticle' => $cmsArticleEntity
        ]);
    }


    /**
     * @Route("/{id}/remove", name="cms_article_remove")
     */
    public function removeAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $cmsArticle = $em->getRepository('AdminBundle:CmsArticle')->find($id);
        if (!$cmsArticle) {
            throw $this->createNotFoundException('Brak wybranego rekordu w bazie danych');
        }
        $em->remove($cmsArticle);
        $em->flush();
        $this->addFlash('remove_success', true);
        return $this->redirectToRoute('admin_cms_article_index');
    }

    public function getDataGrid(Request $request) 
    {
        $visibleColumns = ['main_image', 'date', 'title', 'isActive'];
        $grid = $this->get('grid');
        $em = $this->getDoctrine()->getManager();
        $dgSource = new ApyEntity('AdminBundle:CmsArticle');
        //$dgSource->initQueryBuilder($qb);
        $grid->setSource($dgSource);

        //Main Image
        $MyColumn = new BlankColumn([
            'id' => 'main_image',
            'title' => 'lbl.main_image'
        ]);
        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $this->renderView('@Admin/_Common/apy/datagrid/grid_image.html.twig', [
                'imageDir'      => 'upload/cms_article/main_image/',
                'imageFilename' => $row->getEntity()->getMainImage()
            ]);
        });
        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 0);

        //Title
        $MyColumn = new BlankColumn(array(
            'id'    => 'title',
            'title' => 'lbl_title'
        ));
        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $row->getEntity()->getTitle();
        });
        $grid->addColumn($MyColumn, 1);

        
        //-------------ROW---ACTIONS------
        //EDIT
        $rowAction = new RowAction('record_edit', 'admin_cms_article_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['id']);
        $grid->addRowAction($rowAction);

        //remove btn
        $removeRowAction = new RowAction('record_delete', 'cms_article_remove', false, '_self', ['class' => 'btn btn-danger btn-sm btn-remove']);
        $grid->addRowAction($removeRowAction);


        $grid->setVisibleColumns($visibleColumns);
        $grid->setColumnsOrder(['id', 'main_image', 'title', 'date', 'createdAt', 'city', 'link', 'isActive'], false);
        
        $grid->setDefaultPage(1);
        $grid->setLimits(30);
        $grid->setDefaultOrder('id', 'DESC');
        $grid->hideFilters();
        //$grid->setDefaultOrder('id', 'DESC');
        return $grid;
    }
    
    
    
    
}
