<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="cms_page_file")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsPageFileRepository")
 */
class CmsPageFile
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
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\CmsPage", inversedBy="files")
     * @Gedmo\SortableGroup()
     */
    private $cmsPage;

    

    /**
     * Get id
     *
     * @return integer
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
     * @return CmsPageFile
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
     * @return CmsPageFile
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
     * @return CmsPageFile
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
     * @return CmsPageFile
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
     * @return CmsPageFile
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
     * @return CmsPageFile
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
     * @return CmsPageFile
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
     * Set cmsPage
     *
     * @param \AdminBundle\Entity\CmsPage $cmsPage
     *
     * @return CmsPageFile
     */
    public function setCmsPage(\AdminBundle\Entity\CmsPage $cmsPage = null)
    {
        $this->cmsPage = $cmsPage;

        return $this;
    }

    /**
     * Get cmsPage
     *
     * @return \AdminBundle\Entity\CmsPage
     */
    public function getCmsPage()
    {
        return $this->cmsPage;
    }
}
