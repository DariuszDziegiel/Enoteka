<?php
namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CmsGalleryFile
 * @ORM\Table(name="cms_gallery_file")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsGalleryFileRepository")
 */
class CmsGalleryFile
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $fileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $originalFilename;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\SortablePosition()
     */
    private $sort;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(choices="{'img', 'doc', 'video', 'audio'}")
     */
    private $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $mimeType;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @Gedmo\SortableGroup()
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\CmsGallery", inversedBy="images")
     */
    private $cmsGallery;
    
    
    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return CmsGalleryFile
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set originalFilename
     *
     * @param string $originalFilename
     *
     * @return CmsGalleryFile
     */
    public function setOriginalFilename($originalFilename)
    {
        $this->originalFilename = $originalFilename;

        return $this;
    }

    /**
     * Get originalFilename
     *
     * @return string
     */
    public function getOriginalFilename()
    {
        return $this->originalFilename;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return CmsGalleryFile
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
     * Set extension
     *
     * @param string $extension
     *
     * @return CmsGalleryFile
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return CmsGalleryFile
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return CmsGalleryFile
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CmsGalleryFile
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
     * Set cmsGallery
     *
     * @param \AdminBundle\Entity\CmsGallery $cmsGallery
     *
     * @return CmsGalleryFile
     */
    public function setCmsGallery(\AdminBundle\Entity\CmsGallery $cmsGallery = null)
    {
        $this->cmsGallery = $cmsGallery;

        return $this;
    }

    /**
     * Get cmsGallery
     *
     * @return \AdminBundle\Entity\CmsGallery
     */
    public function getCmsGallery()
    {
        return $this->cmsGallery;
    }
}
