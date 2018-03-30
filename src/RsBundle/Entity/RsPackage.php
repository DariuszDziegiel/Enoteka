<?php

namespace RsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * RsPackage
 *
 * @ORM\Table(name="rs_package")
 * @ORM\Entity(repositoryClass="RsBundle\Repository\RsPackageRepository")
 * @Vich\Uploadable()
 */
class RsPackage
{
    const FILES_DIR      = 'upload/rs_package/files/';
    const MAIN_IMAGE_DIR = 'upload/rs_package/main_image/';
    const DETAILS_IMAGE_DIR = 'upload/rs_package/details_image/';

    use Translatable;
    
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
     * @Vich\UploadableField(mapping="rs_package_main_image", fileNameProperty="mainImage")
     * @Assert\Image(maxSize="10M")
     */
    private $mainImageFile;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $detailsImage = null;

    /**
     * @Vich\UploadableField(mapping="rs_package_details_image", fileNameProperty="detailsImage")
     * @Assert\Image(maxSize="10M")
     */
    private $detailsImageFile;


    /**
     * @ORM\Column(type="decimal", precision=10,scale=2)
     * @Assert\NotBlank()
     * @GRID\Column(title="Cena [PLN]")
     */
    private $price;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minStayDays;

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

  
    public function __construct()
    {
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
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

    public function getFilesDir() {
        return self::FILES_DIR;
    }

    public function getMainImageDir()  {
        return self::MAIN_IMAGE_DIR;
    }

    public function getDetailsImageDir()  {
        return self::DETAILS_IMAGE_DIR;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     * @return RsPackage
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
     * @return RsPackage
     */
    public function setDetailsImageFile(File $image = null)
    {
        $this->detailsImageFile = $image;
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
    public function getDetailsImageFile()
    {
        return $this->detailsImageFile;
    }

    /**
     * Set mainImage
     * @param string $mainImage
     * @return RsPackage
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
     * Set minStayDays
     *
     * @param integer $minStayDays
     *
     * @return RsPackage
     */
    public function setMinStayDays($minStayDays)
    {
        $this->minStayDays = $minStayDays;

        return $this;
    }

    /**
     * Get minStayDays
     *
     * @return integer
     */
    public function getMinStayDays()
    {
        return $this->minStayDays;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return RsPackage
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
     * @return RsPackage
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
     * @return RsPackage
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
     * @return RsPackage
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
     * Set detailsImage
     *
     * @param string $detailsImage
     *
     * @return RsPackage
     */
    public function setDetailsImage($detailsImage)
    {
        $this->detailsImage = $detailsImage;

        return $this;
    }

    /**
     * Get detailsImage
     *
     * @return string
     */
    public function getDetailsImage()
    {
        return $this->detailsImage;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return RsPackage
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
}
