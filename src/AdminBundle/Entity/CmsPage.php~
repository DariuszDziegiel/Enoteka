<?php
namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="cms_page")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsPageRepository")
 * @Vich\Uploadable()
 */
class CmsPage
{
    use Translatable;
    
    const FILES_DIR      = 'upload/cms_page/files/';
    const MAIN_IMAGE_DIR = 'upload/cms_page/main_image/';

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $mainImage = null;

    /**
     * @Vich\UploadableField(mapping="cms_page_main_image", fileNameProperty="mainImage")
     * @Assert\Image(maxSize="4M")
     */
    private $mainImageFile;
    
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
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\CmsPageFile", mappedBy="cmsPage")
     */
    private $files;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\CmsCategory", inversedBy="cmsPages")
     * @Gedmo\SortableGroup()
     */
    private $cmsCategory;
    
    public function __construct() {
        $this->files = new ArrayCollection();
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    
    
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    public function getMainImageDir() {
        return self::MAIN_IMAGE_DIR;
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
     * Set mainImage
     *
     * @param string $mainImage
     *
     * @return CmsPage
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return CmsPage
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
     * @return CmsPage
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
     * @return CmsPage
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
     * Set sort
     *
     * @param integer $sort
     *
     * @return CmsPage
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
     * Add file
     *
     * @param \AdminBundle\Entity\CmsPageFile $file
     *
     * @return CmsPage
     */
    public function addFile(\AdminBundle\Entity\CmsPageFile $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \AdminBundle\Entity\CmsPageFile $file
     */
    public function removeFile(\AdminBundle\Entity\CmsPageFile $file)
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
     * Set cmsCategory
     *
     * @param \AdminBundle\Entity\CmsCategory $cmsCategory
     *
     * @return CmsPage
     */
    public function setCmsCategory(\AdminBundle\Entity\CmsCategory $cmsCategory = null)
    {
        $this->cmsCategory = $cmsCategory;

        return $this;
    }

    /**
     * Get cmsCategory
     *
     * @return \AdminBundle\Entity\CmsCategory
     */
    public function getCmsCategory()
    {
        return $this->cmsCategory;
    }
}
