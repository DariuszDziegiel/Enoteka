<?php
namespace AdminBundle\EventListener\Upload;

use AdminBundle\Entity\CmsArticleFile;
use AdminBundle\Entity\CmsGalleryFile;
use AdminBundle\Entity\CmsPageFile;
use AdminBundle\Entity\CmsStaticPageFile;
use RsBundle\Entity\RsRoomFile;
use Doctrine\ORM\EntityManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Oneup\UploaderBundle\Uploader\Exception\ValidationException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class OneUpFileListener {

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function onUpload(PostPersistEvent $event) {
        $request = $event->getRequest();
        $response = $event->getResponse();

        /** @var File $file */
        $file = $event->getFile();
        if ($file->isExecutable()) {
            $response['error'] = 'No executable files';
            throw new ValidationException('No executable files');
        }

        $entityClass = $request->get('entity_class');
        switch ($entityClass) {
            case 'CmsStaticPage':
                $fileEntity = $this->onUploadCmsStaticPageFile($request, $file);
                break;
            case 'CmsPage':
                $fileEntity = $this->onUploadCmsPageFile($request, $file);
                break;
            case 'CmsArticle':
                $fileEntity = $this->onUploadCmsArticleFile($request, $file);
                break;
            case 'CmsGallery':
                $fileEntity = $this->onUploadCmsGalleryFile($request, $file);
                break;
            case 'RsRoom':
                $fileEntity = $this->onUploadRsRoomFile($request, $file);
                break;
        }

        $response['newFilename'] = $file->getFilename();
        //$response['newFilenameLink'] = $file->getLinkTarget();
        $response['newFilenamePath'] = $file->getRealPath();
        $response['newFilenameExtension'] = $file->guessExtension();
        $response['newFilenameMimeType'] = $file->getMimeType();
        $response['fileId'] = $fileEntity->getId();
    }
    
    //public function onUploadCmsStaticPageFile(Request $request, File $file) : CmsStaticPageFile {
    public function onUploadCmsStaticPageFile(Request $request, File $file) {

        $cmsStaticPageEntity = $this->em
            ->getRepository('AdminBundle:CmsStaticPage')
            ->find($request->get('entity_id'));
        
        $cmsStaticPageFileEntity = new CmsStaticPageFile();
        $cmsStaticPageFileEntity->setCmsStaticPage($cmsStaticPageEntity);
        $cmsStaticPageFileEntity->setFileName($file->getFilename());
        $cmsStaticPageFileEntity->setExtension($file->guessExtension());
        $cmsStaticPageFileEntity->setType($request->get('file_type'));
        $cmsStaticPageFileEntity->setMimeType($file->getMimeType());
        $this->em->persist($cmsStaticPageFileEntity);
        $this->em->flush();
        return $cmsStaticPageFileEntity;
    }


    //public function onUploadCmsPageFile(Request $request, File $file) : CmsPageFile {
    public function onUploadCmsPageFile(Request $request, File $file) {

        $cmsPageEntity = $this->em
            ->getRepository('AdminBundle:CmsPage')
            ->find($request->get('entity_id'));

        $cmsPageFile = new CmsPageFile();
        $cmsPageFile->setCmsPage($cmsPageEntity);
        $cmsPageFile->setFileName($file->getFilename());
        $cmsPageFile->setExtension($file->guessExtension());
        $cmsPageFile->setType($request->get('file_type'));
        $cmsPageFile->setMimeType($file->getMimeType());
        $this->em->persist($cmsPageFile);
        $this->em->flush();
        return $cmsPageFile;
    }

    //public function onUploadCmsArticleFile(Request $request, File $file) : CmsArticleFile {
    public function onUploadCmsArticleFile(Request $request, File $file) {

        $cmsArticleEntity = $this->em
            ->getRepository('AdminBundle:CmsArticle')
            ->find($request->get('entity_id'));

        $cmsArticleFileEntity = new CmsArticleFile();
        $cmsArticleFileEntity->setArticle($cmsArticleEntity);
        $cmsArticleFileEntity->setFileName($file->getFilename());
        $cmsArticleFileEntity->setExtension($file->guessExtension());
        $cmsArticleFileEntity->setType($request->get('file_type'));
        $cmsArticleFileEntity->setMimeType($file->getMimeType());
        $this->em->persist($cmsArticleFileEntity);
        $this->em->flush();
        return $cmsArticleFileEntity;
    }


    public function onUploadRsRoomFile(Request $request, File $file) {
        
        $rsRoom = $this->em
            ->getRepository('RsBundle:RsRoom')
            ->find($request->get('entity_id'));

        $rsRoomFile = new RsRoomFile();
        $rsRoomFile->setRsRoom($rsRoom);
        $rsRoomFile->setFileName($file->getFilename());
        $rsRoomFile->setExtension($file->guessExtension());
        $rsRoomFile->setType($request->get('file_type'));
        $rsRoomFile->setMimeType($file->getMimeType());
        $this->em->persist($rsRoomFile);
        $this->em->flush();
        return $rsRoomFile;
    }


    public function onUploadCmsGalleryFile(Request $request, File $file) {
        $cmsGallery = $this->em
            ->getRepository('AdminBundle:CmsGallery')
            ->find($request->get('entity_id'));

        $cmsGalleryFile = new CmsGalleryFile();
        $cmsGalleryFile->setCmsGallery($cmsGallery);
        $cmsGalleryFile->setFileName($file->getFilename());
        $cmsGalleryFile->setExtension($file->guessExtension());
        $cmsGalleryFile->setType($request->get('file_type'));
        $cmsGalleryFile->setMimeType($file->getMimeType());
        $this->em->persist($cmsGalleryFile);
        $this->em->flush();
        return $cmsGalleryFile;
    }
    
    
}