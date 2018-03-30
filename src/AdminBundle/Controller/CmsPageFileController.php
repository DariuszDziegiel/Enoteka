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
 * @Route("/admin/cms_page_file")
 */
class CmsPageFileController extends Controller
{
    protected $uploadDir = 'upload/cms_page/files/';

    /**
     * @Route("/{id}/remove",
     *     name="cms_page_file_remove",
     *     options = {"expose" = true}
     *     )
     **/
    public function removeAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $file = $entityManager->getRepository('AdminBundle:CmsPageFile')->find($id);
        if (!$file) {
            $response['success'] = false;
            return new JsonResponse($response);
        }

        $fileSystemHelper = $this->get('app.filesystem_helper');
        if ($fileSystemHelper->isFileExists($file->getCmsPage()->getFilesDir(), $file->getFilename())) {
            try {
                $fileSystemHelper->deleteFile($file->getCmsPage()->getFilesDir(), $file->getFilename());
                $entityManager->remove($file);
                $entityManager->flush();
                return new JsonResponse(['success' => true]);
            } catch (IOException $e) {
                return new JsonResponse(['success' => false]);
            }
        }
    }


    /**
     * @Route("/sort",
     *     name="cms_page_file_sort",
     *     options = { "expose" = true }
     * )
     **/
    public function sortAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $fileRepository = $em->getRepository('AdminBundle:CmsPageFile');
        parse_str(str_replace(';', '', $request->get('serial')), $sort);

        if (empty($sort)) {
            return new JsonResponse('Empty sort array', 400);
        }

        foreach ($sort['sort'] as $position => $recordId) {
            $file = $fileRepository->find($recordId);
            if (!$file) continue;
            $file->setSort($position);
            $em->flush();
        }

        return new JsonResponse('success', 200);
    }



}
