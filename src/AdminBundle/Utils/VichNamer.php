<?php
namespace AdminBundle\Utils;

use AppBundle\Utils\FilesystemHelper;
use AppBundle\Utils\StringHelper;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;


class VichNamer implements NamerInterface {

    protected $_stringHelper;
    protected $_filesystemHelper;

    public function __construct(StringHelper $stringHelper, FilesystemHelper $filesystemHelper)
    {
        $this->_stringHelper = $stringHelper;
        $this->_filesystemHelper = $filesystemHelper;
    }

    /**
     * Rename uploaded file
     * @param object $object
     * @param PropertyMapping $mapping
     */
    public function name($object, PropertyMapping $mapping)
    {
        $file = $mapping->getFile($object);
        $uploadDestinationDir = $mapping->getUploadDestination();
        $fileExtension  = $file->guessExtension();
        $fileName = substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), '.'));
        //sanitize filename
        $newFileName = $this->_stringHelper->sanitize($fileName);
        $newFullFileName = $newFileName .'.'. $fileExtension;
        return $this->_filesystemHelper->checkFilenameInDir($uploadDestinationDir, $newFullFileName);
    }
    




}