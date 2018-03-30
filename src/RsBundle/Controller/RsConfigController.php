<?php

namespace RsBundle\Controller;

use RsBundle\Entity\RsConfig;
use RsBundle\Form\RsConfigType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use APY\DataGridBundle\Grid\Source\Entity as ApyEntity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/rs_config", defaults={"_locale": "pl"})
 */
class RsConfigController extends Controller
{

    /**
     * @Breadcrumb("rs_config_about", routeName="rs_config_about")
     * @Route("/rs_config_about", name="rs_config_about")
     */
    public function aboutAction(Request $request) {
        /** @var RsConfig $rsConfigEntity */
        $rsConfigEntity = $this->getDoctrine()->getRepository('RsBundle:RsConfig')->find(1);
        if (!$rsConfigEntity) {
            $rsConfigEntity = new RsConfig();
        }
        $form = $this->createForm(RsConfigType::class, $rsConfigEntity, [
            'validation_groups' => ['basic_data']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $this->getDoctrine()->getRepository('RsBundle:RsConfig')->save($rsConfigEntity);
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('rs_config_about');
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
                return $this->redirectToRoute('rs_config_about');
            }
        }
        return $this->render('@Rs/RsConfig/rs_config_about_form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Breadcrumb("rs_config_data", routeName="rs_config_data")
     * @Route("/rs_config_data", name="rs_config_data")
     */
    public function dataAction(Request $request) {
        /** @var RsConfig $rsConfigEntity */
        $rsConfigEntity = $this->getDoctrine()->getRepository('RsBundle:RsConfig')->find(1);
        if (!$rsConfigEntity) {
            $rsConfigEntity = new RsConfig();
        }
        $form = $this->createForm(RsConfigType::class, $rsConfigEntity, [
            'validation_groups' => ['address', 'contact', 'invoice']
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try  {
                $this->getDoctrine()->getRepository('RsBundle:RsConfig')->save($rsConfigEntity);
                $this->addFlash('form_success', true);
                return $this->redirectToRoute('rs_config_data');
            } catch (Exception $e) {
                $this->addFlash('form_error', true);
                return $this->redirectToRoute('rs_config_data');
            }
        }
        return $this->render('@Rs/RsConfig/rs_config_data_form.html.twig', [
            'form' => $form->createView()
        ]);


    }








}
