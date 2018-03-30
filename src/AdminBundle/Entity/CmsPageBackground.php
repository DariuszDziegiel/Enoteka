<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

/**
 * CmsPageBackground
 *
 * @ORM\Table(name="cms_page_background")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsPageBackgroundRepository")
 * @Uploadable()
 */
class CmsPageBackground implements \JsonSerializable
{
    const FILES_DIR = 'upload/page_background/';

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $image = null;

    /**
     * @UploadableField(mapping="cms_page_background_image", fileNameProperty="image")
     * @Assert\Image(maxSize="20M")
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="integer")
     * @Gedmo\SortablePosition()
     * @Assert\GreaterThanOrEqual(value="0")
     */
    protected $sort;

    /** @ORM\Column(type="boolean") */
    protected $isActive = false;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;
    
    public function __construct()
    {
    }


    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'    => $this->getId(),
            'sort'  => $this->getSort(),
            'image' => $this->getImage()
        ];
    }

    /**
     * @return string
     */
    public function getFilesDir() {
        return self::FILES_DIR;
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     * @return CmsArticle
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }
    
    

    /**
     * Set image
     *
     * @param string $image
     *
     * @return CmsPageBackground
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return CmsPageBackground
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return CmsPageBackground
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CmsPageBackground
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return CmsPageBackground
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
