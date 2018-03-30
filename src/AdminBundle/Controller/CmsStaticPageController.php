<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\CmsStaticPage;
use AdminBundle\Form\CmsStaticPageType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Row;
use APY\DataGridBundle\Grid\Source\Entity as ApyEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;


/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/cmsstaticpage", defaults={"_locale": "pl"})
 */
class CmsStaticPageController extends Controller
{
    /**
     * @Breadcrumb("admin_cms_static_page_index", routeName="admin_cms_static_page_index")
     * @Route("/index", name="admin_cms_static_page_index")
     */
    public function indexAction(Request $request)
    {
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('AdminBundle:CmsStaticPage:index.html.twig', [
            'grid' => $grid
        ]);
    }

    /**
     *  @Breadcrumb("admin_cms_static_page_index", routeName="admin_cms_static_page_index")
     *  @Route("/add", name="admin_cms_static_page_add")
     */
    public function addAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();

        $cmsStaticPageObj = new CmsStaticPage();
        $form = $this->createForm(CmsStaticPageType::class, $cmsStaticPageObj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                /** @var CmsStaticPage $cmsStaticPageObj */
                //$cmsStaticPageObj = $form->getData();
                $entityManager->getRepository('AdminBundle:CmsStaticPage')->save($cmsStaticPageObj);
                
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('admin_cms_static_page_edit', ['param' => $cmsStaticPageObj->getParam()]);
                
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
            }
        }

        $this->get("apy_breadcrumb_trail")->add('record_add', 'admin_cms_static_page_add');
        return $this->render('@Admin/CmsStaticPage/admin_cms_static_page_form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     *  @Breadcrumb("admin_cms_static_page_index", routeName="admin_cms_static_page_index")
     *  @Route("/{param}/edit", name="admin_cms_static_page_edit")
     */
    public function editAction($param, Request $request) {

        
        $entityManager = $this->getDoctrine()->getManager();
        /** @var CmsStaticPage $cmsStaticPageObj */
        $cmsStaticPageObj = $entityManager->getRepository('AdminBundle:CmsStaticPage')->getByParam($param);
        if (!$cmsStaticPageObj) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CmsStaticPageType::class, $cmsStaticPageObj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $entityManager->getRepository('AdminBundle:CmsStaticPage')->save($cmsStaticPageObj, false);
                $this->addFlash('form_success', true);

                return $this->redirectToRoute('admin_cms_static_page_edit', ['param' => $cmsStaticPageObj->getParam()]);
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
            }
        }
        //images
        $images = $entityManager->getRepository('AdminBundle:CmsStaticPageFile')->getFilesByCmsStaticPage($cmsStaticPageObj);

        $this->get("apy_breadcrumb_trail")->add($cmsStaticPageObj->getTitle(), 'admin_cms_static_page_edit', ['param' => $param]);
        return $this->render('@Admin/CmsStaticPage/admin_cms_static_page_form.html.twig', array(
            'form' => $form->createView(),
            'cmsStaticPage' => $cmsStaticPageObj,
            'images'        => $images
        ));
    }


    /**
     * --- DATA GRID ----
     * @param Request $request
     * @return \APY\DataGridBundle\Grid\Grid
     */
    public function getDataGrid(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $grid = $this->get('grid');
        $dgSource = new ApyEntity('AdminBundle:CmsStaticPage');
        $grid->setDefaultOrder('sort', 'ASC');
        $grid->setSource($dgSource);

        //Main Image
        $MyColumn = new BlankColumn(array('id' => 'mainImage_preview', 'title' => 'lbl.main_image'));
        $MyColumn->manipulateRenderCell(function ($value, $row, $router) {
            /** @var $row Row */
            if (!$row->getEntity()->getIsHasMainImage()) {
                echo '-----';
                return;
            }
            echo $this->renderView('@Admin/_Common/apy/datagrid/grid_image.html.twig', [
                'imageDir'      => 'upload/cms_static_page/main_image/',
                'imageFilename' => $row->getField('mainImage')
            ]);
        });
        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 1);

        //Main page image
        /**
        $MyColumn = new BlankColumn(array('id' => 'mainPageImage_preview', 'title' => 'mainPageImage'));
        $MyColumn->manipulateRenderCell(function ($value, $row, $router) {
            if (!$row->getEntity()->getMainPageImage()) {
                echo '-----';
                return;
            }
            echo $this->renderView('@Admin/_Common/apy/datagrid/grid_image.html.twig', [
                'imageDir'      => 'upload/cms_static_page/main_image/',
                'imageFilename' => $row->getField('mainPageImage')
            ]);
        });
        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 2);
         **/


        $MyColumn = new BlankColumn(array('id' => 'title', 'title' => 'lbl_title'));
        $MyColumn->manipulateRenderCell(function ($value, $row, $router) {
            /** @var $row Row */
            return $row->getEntity()->getTitle();
        });
        $grid->addColumn($MyColumn, 3);



        //Page Gallery preview
        $galleryPreviewCol = new BlankColumn(['id' => 'images_preview', 'title' => 'Zdjęcia']);
        $galleryPreviewCol->setSize(600);
        $galleryPreviewCol->manipulateRenderCell(function($value, Row $row, $router) use ($em) {
            /** @var $cmsStaticPage CmsStaticPage */
            $cmsStaticPage = $row->getEntity();
            $images = $em->getRepository('AdminBundle:CmsStaticPageFile')->getFilesByCmsStaticPage($cmsStaticPage);
            echo $this->renderView('@Admin/CmsStaticPage/index/cms_static_page_gallery_preview.html.twig', [
                'images'        => $images,
                'cmsStaticPage' => $cmsStaticPage
            ]);
        });
        $grid->addColumn($galleryPreviewCol, 4);



        //ROW ACTIONS
        $rowAction = new RowAction('record_edit', 'admin_cms_static_page_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['param']);
        $grid->addRowAction($rowAction);

        $grid->setDefaultPage(1);
        $grid->setLimits(50);
        $grid->setVisibleColumns(['mainImage_preview', 'title', 'images_preview']);
        $grid->hideFilters();
        return $grid;
    }
    
    
}
