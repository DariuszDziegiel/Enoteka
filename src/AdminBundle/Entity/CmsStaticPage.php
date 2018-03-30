<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Table(name="cms_static_page")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsStaticPageRepository")
 * @Vich\Uploadable()
 * @UniqueEntity("param")
 */
class CmsStaticPage
{
    use ORMBehaviors\Translatable\Translatable;
    
    const FILES_DIR = 'upload/cms_static_page/files/';
    const MAIN_IMAGE_DIR = 'upload/cms_static_page/main_image/';
    
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\Length(min="2")
     * @Assert\NotBlank()
     */
    private $param;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $mainImage = null;

    /**
     * @Vich\UploadableField(mapping="cms_static_page_main_image", fileNameProperty="mainImage")
     * @Assert\Image(maxSize="2M")
     */
    private $mainImageFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $mainPageImage = null;
    
    /**
     * @Vich\UploadableField(mapping="cms_static_page_main_page_image", fileNameProperty="mainPageImage")
     * @Assert\Image(maxSize="2M")
     */
    private $mainPageImageFile;

    /** @ORM\Column(type="boolean") */
    private $isHasSeo = false;

    /** @ORM\Column(type="boolean") */
    private $isHasGallery = false;

    /** @ORM\Column(type="boolean") */
    private $isHasAttachments = false;

    /** @ORM\Column(type="boolean") */
    private $isHasMainImage = false;

    /** @ORM\Column(type="boolean") */
    private $isHasMainPageImage = false;
    
    /** @ORM\Column(type="boolean") */
    private $isHasSubtitle = false;

    /** @ORM\Column(type="boolean") */
    private $isHasDescriptionShort = false;

    /** @ORM\Column(type="boolean") */
    private $isOnMainPage = false;

    /** @ORM\Column(type="boolean") */
    private $isActive= false;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;
    /**
     * @ORM\Column(type="integer")
     * @Gedmo\SortablePosition()
     */
    private $sort;
    
    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\CmsStaticPageFile", mappedBy="cmsStaticPage")
     */
    private $files;
    

    /**---------------------------------------------------------------------------------------------------------------*/
    public function __construct()
    {
        //$this->translations = new ArrayCollection();
        $this->files = new ArrayCollection();
    }


    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }


    public function getTitle() {
        return $this->translate()->getTitle();
    }

    public function getSubTitle() {
        return $this->translate()->getSubTitle();
    }

    public function getDescription() {
        return $this->translate()->getDescription();
    }

    public function getDescriptionShort() {
        return $this->translate()->getDescriptionShort();
    }


    public function getSeoTitle() {
        return $this->translate()->getSeoTitle();
    }
    public function getSeoKeywords() {
        return $this->translate()->getSeoKeywords();
    }
    public function getSeoDescription() {
        return $this->translate()->getSeoDescription();
    }


    public function getSlug() {
        return $this->translate()->getSlug();
    }
    
    /**
     * @param $type
     * @return \Doctrine\Common\Collections\Collection|static
     */
    public function getFilesByType($type) {
        $expr = Criteria::expr();
        $criteria = Criteria::create()
            ->where($expr->eq('type', $type))
            ->orderBy(
                ['id' => Criteria::ASC]
            );
        return $files = $this->files->matching($criteria);
    }
    
    public function getFilesDir() {
        return self::FILES_DIR;
    }
    
    public function getMainImageDir()  {
        return self::MAIN_IMAGE_DIR;
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set param
     *
     * @param string $param
     *
     * @return CmsStaticPage
     */
    public function setParam($param)
    {
        $this->param = $param;

        return $this;
    }

    /**
     * Get param
     *
     * @return string
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * Set isHasSeo
     *
     * @param boolean $isHasSeo
     *
     * @return CmsStaticPage
     */
    public function setIsHasSeo($isHasSeo)
    {
        $this->isHasSeo = $isHasSeo;

        return $this;
    }

    /**
     * Get isHasSeo
     *
     * @return boolean
     */
    public function getIsHasSeo()
    {
        return $this->isHasSeo;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CmsStaticPage
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
     * @return CmsStaticPage
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

    /**
     * Set isHasGallery
     *
     * @param boolean $isHasGallery
     *
     * @return CmsStaticPage
     */
    public function setIsHasGallery($isHasGallery)
    {
        $this->isHasGallery = $isHasGallery;

        return $this;
    }

    /**
     * Get isHasGallery
     *
     * @return boolean
     */
    public function getIsHasGallery()
    {
        return $this->isHasGallery;
    }
    

    /**
     * Set mainImage
     *
     * @param string $mainImage
     *
     * @return CmsStaticPage
     */
    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    /**
     * Get mainImage
     *
     * @return string
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * Set isHasMainImage
     *
     * @param boolean $isHasMainImage
     *
     * @return CmsStaticPage
     */
    public function setIsHasMainImage($isHasMainImage)
    {
        $this->isHasMainImage = $isHasMainImage;

        return $this;
    }

    /**
     * Get isHasMainImage
     *
     * @return boolean
     */
    public function getIsHasMainImage()
    {
        return $this->isHasMainImage;
    }


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     * @return CmsStaticPage
     */
    public function setMainImageFile(File $image = null)
    {
        $this->mainImageFile = $image;
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
    public function getMainImageFile()
    {
        return $this->mainImageFile;
    }




    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     * @return CmsStaticPage
     */
    public function setMainPageImageFile(File $image = null)
    {
        $this->mainPageImageFile = $image;
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
    public function getMainPageImageFile()
    {
        return $this->mainPageImageFile;
    }

    /**
     * Add file
     *
     * @param \AdminBundle\Entity\CmsStaticPageFile $file
     *
     * @return CmsStaticPage
     */
    public function addFile(\AdminBundle\Entity\CmsStaticPageFile $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \AdminBundle\Entity\CmsStaticPageFile $file
     */
    public function removeFile(\AdminBundle\Entity\CmsStaticPageFile $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set isHasAttachments
     *
     * @param boolean $isHasAttachments
     *
     * @return CmsStaticPage
     */
    public function setIsHasAttachments($isHasAttachments)
    {
        $this->isHasAttachments = $isHasAttachments;

        return $this;
    }

    /**
     * Get isHasAttachments
     *
     * @return boolean
     */
    public function getIsHasAttachments()
    {
        return $this->isHasAttachments;
    }

    /**
     * Set mainPageImage
     *
     * @param string $mainPageImage
     *
     * @return CmsStaticPage
     */
    public function setMainPageImage($mainPageImage)
    {
        $this->mainPageImage = $mainPageImage;

        return $this;
    }

    /**
     * Get mainPageImage
     *
     * @return string
     */
    public function getMainPageImage()
    {
        return $this->mainPageImage;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return CmsStaticPage
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
     * Set isHasMainPageImage
     *
     * @param boolean $isHasMainPageImage
     *
     * @return CmsStaticPage
     */
    public function setIsHasMainPageImage($isHasMainPageImage)
    {
        $this->isHasMainPageImage = $isHasMainPageImage;

        return $this;
    }

    /**
     * Get isHasMainPageImage
     *
     * @return boolean
     */
    public function getIsHasMainPageImage()
    {
        return $this->isHasMainPageImage;
    }

    /**
     * Set isHasDescriptionShort
     *
     * @param boolean $isHasDescriptionShort
     *
     * @return CmsStaticPage
     */
    public function setIsHasDescriptionShort($isHasDescriptionShort)
    {
        $this->isHasDescriptionShort = $isHasDescriptionShort;

        return $this;
    }

    /**
     * Get isHasDescriptionShort
     *
     * @return boolean
     */
    public function getIsHasDescriptionShort()
    {
        return $this->isHasDescriptionShort;
    }

    /**
     * Set isOnMainPage
     *
     * @param boolean $isOnMainPage
     *
     * @return CmsStaticPage
     */
    public function setIsOnMainPage($isOnMainPage)
    {
        $this->isOnMainPage = $isOnMainPage;

        return $this;
    }

    /**
     * Get isOnMainPage
     *
     * @return boolean
     */
    public function getIsOnMainPage()
    {
        return $this->isOnMainPage;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return CmsStaticPage
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
     * Set isHasSubtitle
     *
     * @param boolean $isHasSubtitle
     *
     * @return CmsStaticPage
     */
    public function setIsHasSubtitle($isHasSubtitle)
    {
        $this->isHasSubtitle = $isHasSubtitle;

        return $this;
    }

    /**
     * Get isHasSubtitle
     *
     * @return boolean
     */
    public function getIsHasSubtitle()
    {
        return $this->isHasSubtitle;
    }
}
