<?php

namespace RsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * RsFacilityItem

 * @ORM\Table(name="rs_facility_item")
 * @ORM\Entity(repositoryClass="RsBundle\Repository\RsFacilityItemRepository")
 * @Vich\Uploadable()
 */
class RsFacilityItem
{
    use Translatable;

    const FILES_DIR = 'upload/rs_facility/files/';
    const MAIN_IMAGE_DIR = 'upload/rs_facility/main_image/';


    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isActive = false;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @GRID\Column(title="lbl.iconDefault")
     */
    private $iconDefault;


    /**
     * @ORM\Column(type="string", nullable=true)
     * @GRID\Column(title="lbl.icon")
     */
    private $mainImage = null;

    /**
     * @Vich\UploadableField(mapping="rs_facility_main_image", fileNameProperty="mainImage")
     * @Assert\Image(maxSize="10M", maxWidth="50", maxHeight="50")
     */
    private $mainImageFile;
    
    
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
     * @ORM\ManyToMany(targetEntity="RsBundle\Entity\RsRoom", mappedBy="facilityItems")
     * @ORM\JoinTable(name="rs_room_2_rs_facility_item")
     */
    private $rooms;
    
    /**
     * @Assert\Valid()
     */
    protected $translations;

    //-------------------------------------------------------------------------------------------------------------------


    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->rooms = new ArrayCollection();
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return RsFacilityItem
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
     * @return RsFacilityItem
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
     * @return RsFacilityItem
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
     * Add room
     *
     * @param \RsBundle\Entity\RsRoom $room
     *
     * @return RsFacilityItem
     */
    public function addRoom(\RsBundle\Entity\RsRoom $room)
    {
        $this->rooms[] = $room;

        return $this;
    }

    /**
     * Remove room
     *
     * @param \RsBundle\Entity\RsRoom $room
     */
    public function removeRoom(\RsBundle\Entity\RsRoom $room)
    {
        $this->rooms->removeElement($room);
    }

    /**
     * Get rooms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRooms()
    {
        return $this->rooms;
    }
    
    
    public function getTitle() {
        return $this->translate()->getTitle();
    }

    public function getDescription() {
        return $this->translate()->getDescription();
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


    public function getFilesDir() {
        return self::FILES_DIR;
    }

    public function getMainImageDir() {
        return self::MAIN_IMAGE_DIR;
    }

    

    /**
     * Set iconDefault
     *
     * @param string $iconDefault
     *
     * @return RsFacilityItem
     */
    public function setIconDefault($iconDefault)
    {
        $this->iconDefault = $iconDefault;

        return $this;
    }

    /**
     * Get iconDefault
     *
     * @return string
     */
    public function getIconDefault()
    {
        return $this->iconDefault;
    }

    /**
     * Set mainImage
     *
     * @param string $mainImage
     *
     * @return RsFacilityItem
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
}
