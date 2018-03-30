<?php
namespace AppBundle\Utils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader {

    /**
     * @var StringHelper AppBundle\Utils\
     */
    private $stringHelper;

    public function __construct(StringHelper $stringHelper)
    {
        $this->stringHelper = $stringHelper;
    }

    public function upload(UploadedFile $file, $targetDir) {
        //@TODO: keep original filename / slug
        $fileExtension  = $file->guessExtension();
        $fileName = substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), '.'));
        $newFileName = $this->stringHelper->sanitize($fileName). '.' .$fileExtension;
        
        $file->move($targetDir, $newFileName);
        return $newFileName;
    }


   




}