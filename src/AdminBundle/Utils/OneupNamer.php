<?php
namespace AdminBundle\Utils;

use AppBundle\Utils\FilesystemHelper;
use AppBundle\Utils\StringHelper;
use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class OneupNamer implements NamerInterface{

    protected $_stringHelper;
    protected $_filesystemHelper;
    
    public function __construct(StringHelper $stringHelper, FilesystemHelper $filesystemHelper)
    {
        $this->_stringHelper = $stringHelper;
        $this->_filesystemHelper = $filesystemHelper;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function name(FileInterface $file) {
        //$uploadDestinationDir = $file->getLinkTarget();
        $fileExtension  = $file->getExtension();
        $fileNameOriginal = substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), '.'));
        
        //sanitize filename
        $newFileName = $this->_stringHelper->sanitize($fileNameOriginal);
        $newFullFileName = $newFileName .'_'. uniqid() .'.'. $fileExtension;

        return $newFullFileName;
    }


}