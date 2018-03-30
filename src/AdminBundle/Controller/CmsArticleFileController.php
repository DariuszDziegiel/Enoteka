<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\CmsArticleFile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/cms_article_file")
 */
class CmsArticleFileController extends Controller
{
    protected $uploadDir = 'upload/cms_article/files/';

    /**
     * @Route("/{id}/remove",
     *     name="cms_article_file_remove",
     *     options = { "expose" = true }
     * )
     */
    public function removeAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $file = $entityManager->getRepository('AdminBundle:CmsArticleFile')->find($id);
        if (!$file) {
            $response['success'] = false;
            return new JsonResponse($response);
        }
        /** @var CmsArticleFile $file */
        $fileSystemHelper = $this->get('app.filesystem_helper');
        if ($fileSystemHelper->isFileExists($file->getArticle()->getFilesDir(), $file->getFilename())) {
            try {
                $fileSystemHelper->deleteFile($file->getArticle()->getFilesDir(), $file->getFilename());
                $entityManager->remove($file);
                $entityManager->flush();
                return new JsonResponse(['success' => true]);
            } catch (IOException $e) {
                return new JsonResponse(['success' => false]);
            }
        }

    }

}
