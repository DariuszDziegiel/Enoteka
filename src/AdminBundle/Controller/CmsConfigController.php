<?php
namespace AdminBundle\Controller;


use AdminBundle\Entity\CmsConfig;
use AdminBundle\Form\CmsConfigForm;
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
 * @Route("/admin/cms_config")
 * @Security("has_role('ROLE_ADMIN')")
 */
class CmsConfigController extends Controller {

    /**
     * @Route("/index", name="cms_config_index")
     * @Breadcrumb("cms_config_index", routeName="cms_config_index")
     */
    public function indexAction(Request $request) {
        $grid = $this->getDataGrid($request);
        return $grid->getGridResponse('AdminBundle:CmsConfig:cms_config_index.html.twig', [
            'grid' => $grid
        ]);
    }

    /**
     * @Route("/{configKey}/edit", name="cms_config_edit")
     * @Breadcrumb("cms_config_index", routeName="cms_config_index")
     */
    public function editAction($configKey, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $cmsConfigRepository = $em->getRepository('AdminBundle:CmsConfig');

        /** @var CmsConfig $cmsConfigEntity */
        $cmsConfigEntity = $cmsConfigRepository->findOneBy(['configKey' => $configKey]);
        if (!$cmsConfigEntity) {
            return $this->redirectToRoute('admin_default');
        }

        $form = $this->createForm(CmsConfigForm::class, $cmsConfigEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('form_success', true);
            return $this->redirectToRoute('cms_config_edit', ['configKey' => $cmsConfigEntity->getConfigKey()]);
        }

        $this->get('apy_breadcrumb_trail')
            ->add($cmsConfigEntity->getConfigTitle(), 'cms_config_edit', [
                'configKey' => $cmsConfigEntity->getConfigKey()
            ]);

        return $this->render('@Admin/CmsConfig/cms_config_form.html.twig', [
            'form'      => $form->createView(),
            'cmsConfig' => $cmsConfigEntity
        ]);
    }



    public function getDataGrid(Request $request) {
        
        $grid = $this->get('grid');
        $dgSource = new ApyEntity('AdminBundle:CmsConfig');
        $grid->setDefaultOrder('configTitle', 'ASC');
        $grid->setSource($dgSource);
        
        //------------------Main Image-------------------------------------------------------------------------
        $MyColumn = new BlankColumn([
            'id'    => 'mainImage_preview',
            'title' => 'lbl.main_image'
        ]);
        $MyColumn->manipulateRenderCell(function ($value, Row $row, $router) {
            echo $this->renderView('@Admin/_Common/apy/datagrid/grid_image.html.twig', [
                'imageDir'      => 'upload/cms_config/',
                'imageFilename' => $row->getField('image')
            ]);
        });
        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 0);


        //attachment preview
        $column = new BlankColumn([
            'id'    => 'attachmentFile_preview',
            'title' => 'Załącznik'
        ]);

        $assets = $this->get('assets.packages');
        $column->manipulateRenderCell(function ($value, Row $row, $router) use ($assets) {
            /** @var CmsConfig $cmsConfig */
            $cmsConfig = $row->getEntity();
            if ($cmsConfig->getIsHasAttachment() && $cmsConfig->getAttachment()) {
                echo '<a href="' .$assets->getUrl('upload/cms_config'). '/' .$cmsConfig->getAttachment(). '" target="_blank">' . $cmsConfig->getAttachment(). '</a>';
                return;
            }
            echo '---';
        });
        $grid->addColumn($column);


        //---------Config value -------------------------------------
        $MyColumn = new BlankColumn([
            'id' => 'value',
            'title' => 'Wartość']
        );

        $MyColumn->manipulateRenderCell(function ($value, $row, $router) {
            /** @var $cmsConfig CmsConfig */
            $cmsConfig = $row->getEntity();
            if ($cmsConfig->getIsTranslatable()) {
                echo $cmsConfig->getConfigDescription();
                return;
            }
            echo htmlspecialchars($cmsConfig->getConfigValue());
        });
        
        $MyColumn->setSize(100);
        $grid->addColumn($MyColumn, 2);


        //ROW ACTIONS
        $rowAction = new RowAction('record_edit', 'cms_config_edit', false, '_self', ['class' => 'btn btn-primary btn-sm']);
        $rowAction->setRouteParameters(['configKey']);
        $grid->addRowAction($rowAction);

        $grid->setDefaultPage(1);
        $grid->setLimits(50);
        $grid->setVisibleColumns(['mainImage_preview', 'attachmentFile_preview', 'configTitle', 'value']);
        $grid->setColumnsOrder(['configTitle', 'value']);

        $grid->hideFilters();
        return $grid;
    }



}