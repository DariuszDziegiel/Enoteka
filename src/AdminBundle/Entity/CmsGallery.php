<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Criteria;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


/**
 * CmsGallery
 *
 * @ORM\Table(name="cms_gallery")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsGalleryRepository")
 * @Vich\Uploadable()
 */
class CmsGallery
{

    const FILES_DIR = 'upload/cms_gallery/files/';
    const MAIN_IMAGE_DIR = 'upload/cms_gallery/main_image/';

    use Translatable;
    /**
     * @var int
     *
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
     * @Vich\UploadableField(mapping="cms_gallery_main_image", fileNameProperty="mainImage")
     * @Assert\Image(maxSize="10M")
     */
    private $mainImageFile;

    /**
     * @ORM\Column(type="integer")
     * @Gedmo\SortablePosition()
     * @Assert\GreaterThanOrEqual(value="0")
     */
    private $sort;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = false;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     **/
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;
    
    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\CmsGalleryFile", mappedBy="cmsGallery")
     */
    private $images;
    
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }


    public function getFilesDir() {
        return self::FILES_DIR;
    }

    public function getMainImageDir()  {
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
    
    public function getMainImageFile() {
        return $this->mainImageFile;
    }





    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mainImage
     *
     * @param string $mainImage
     *
     * @return CmsGallery
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
     * Set sort
     *
     * @param integer $sort
     *
     * @return CmsGallery
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
     * @return CmsGallery
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
     * @return CmsGallery
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
     * @return CmsGallery
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
     * Add image
     *
     * @param \AdminBundle\Entity\CmsGalleryFile $image
     *
     * @return CmsGallery
     */
    public function addImage(\AdminBundle\Entity\CmsGalleryFile $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AdminBundle\Entity\CmsGalleryFile $image
     */
    public function removeImage(\AdminBundle\Entity\CmsGalleryFile $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
