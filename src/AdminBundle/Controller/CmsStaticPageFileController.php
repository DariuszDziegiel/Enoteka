<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/cms_static_page_file")
 */
class CmsStaticPageFileController extends Controller
{
    
    protected $uploadDir = 'upload/cms_static_page/files/';
    
    
    /**
     * @Route("/{id}/remove",
     *     name="cms_static_page_file_remove",
     *     options = { "expose" = true }
     * )
     */
    public function removeAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cmsStaticPageFile = $entityManager->getRepository('AdminBundle:CmsStaticPageFile')->find($id);
        if (!$cmsStaticPageFile) {
            $response['success'] = false;
            return new JsonResponse($response);
        }

        $fileSystemHelper = $this->get('app.filesystem_helper');
        if ($fileSystemHelper->isFileExists($cmsStaticPageFile->getCmsStaticPage()->getFilesDir(), $cmsStaticPageFile->getFilename())) {
            try {
                $fileSystemHelper->deleteFile($cmsStaticPageFile->getCmsStaticPage()->getFilesDir(), $cmsStaticPageFile->getFilename());
                $entityManager->remove($cmsStaticPageFile);
                $entityManager->flush();
                return new JsonResponse(['success' => true]);
            } catch (IOException $e) {
                return new JsonResponse(['success' => false]);
            }
        }
    }
    
    /**
     * @Route("/sort",
     *     name="cms_static_page_file_sort",
     *     options = { "expose" = true }
     * )
     */
    public function sortAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $cmsStaticPageFileRepository = $em->getRepository('AdminBundle:CmsStaticPageFile');
        parse_str(str_replace(';', '', $request->get('serial')), $sort);

        if (empty($sort)) {
            return new JsonResponse('Empty sort array', 400);
        }

        foreach ($sort['sort'] as $position => $recordId) {
            $cmsStaticPageFile = $cmsStaticPageFileRepository->find($recordId);
            if (!$cmsStaticPageFile) continue;
            $cmsStaticPageFile->setSort($position);
            $em->flush();
        }

        return new JsonResponse('success', 200);
    }
    
    
}
