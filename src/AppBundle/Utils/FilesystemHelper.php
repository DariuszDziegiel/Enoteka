<?php
namespace AppBundle\Utils;

use Symfony\Component\Filesystem\Filesystem;

class FilesystemHelper {

    protected $_filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->_filesystem = $filesystem;
    }

    /**
     * Check if given filename exists in directory
     * @param $targetDir
     * @param $fileName
     * @return string
     */
    public function checkFilenameInDir($targetDir, $fileName) {
        $targetFile = $targetDir . '/' . $fileName;
        if (!$this->_filesystem->exists($targetFile)) {
            return $fileName;
        }
        $newFilename = '1_' . $fileName;
        $i = 2;
        while (file_exists($targetDir . '/' . $newFilename)) {
            $newFilename = $i . '_' . $fileName;;
            $i++;
        }
        return $newFilename;
    }


    public function mkdir($targetDir, $chmod = 0777) {
        $this->_filesystem->mkdir($targetDir, $chmod);
    }

    public function isFileExists($targetDir, $filename) {
        return $this->_filesystem->exists($targetDir . '/' . $filename);
    }

    public function deleteFile($targetDir, $filename) {
        $this->_filesystem->remove($targetDir . '/' . $filename);
    }

    



}