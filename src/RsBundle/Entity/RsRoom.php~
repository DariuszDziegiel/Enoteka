<?php

namespace RsBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * RsRoom
 *
 * @ORM\Table(name="rs_room")
 * @ORM\Entity(repositoryClass="RsBundle\Repository\RsRoomRepository")
 * @Vich\Uploadable()
 */
class RsRoom
{

    const FILES_DIR = 'upload/rs_room/files/';
    const MAIN_IMAGE_DIR = 'upload/rs_room/main_image/';


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
     * @Vich\UploadableField(mapping="rs_room_main_image", fileNameProperty="mainImage")
     * @Assert\Image(maxSize="10M")
     */
    private $mainImageFile;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(type="numeric")
     * @Assert\Range(min="1")
     * @Assert\NotBlank()
     */
    private $maxAdults;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(type="numeric")
     * @Assert\Range(min="0")
     */
    private $maxKids;




    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(value="0")
     * @GRID\Column(title="lbl.single_beds")
     */
    private $singleBeds = 0;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(value="0")
     * @GRID\Column(title="lbl.double_beds")
     */
    private $doubleBeds = 0;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(value="0")
     * @GRID\Column(title="lbl.additional_beds")
     */
    private $additionalBeds = 0;
    

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     * @GRID\Column(title="lbl.area")
     * 
     */
    private $area;


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
     * @ORM\ManyToMany(targetEntity="RsBundle\Entity\RsFacilityItem", inversedBy="rooms")
     * @ORM\JoinTable(name="rs_room_2_rs_facility_item")
     * @Assert\Valid()
     */
    private $facilityItems;


    /**
     * @ORM\OneToMany(targetEntity="RsBundle\Entity\RsRoomFile", mappedBy="rsRoom")
     */
    private $files;
    
    /**
     * @Assert\Valid()
     */
    protected $translations;

    //-------------------------------------------------------------------------------------------------------------------
    public function __construct()
    {
        $this->facilityItems  = new ArrayCollection();
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
     * Set maxAdults
     * @param integer $maxAdults
     * @return RsRoom
     */
    public function setMaxAdults($maxAdults)
    {
        $this->maxAdults = $maxAdults;

        return $this;
    }

    /**
     * Get maxAdults
     *
     * @return integer
     */
    public function getMaxAdults()
    {
        return $this->maxAdults;
    }

    /**
     * Set maxKids
     *
     * @param integer $maxKids
     *
     * @return RsRoom
     */
    public function setMaxKids($maxKids)
    {
        $this->maxKids = $maxKids;

        return $this;
    }

    /**
     * Get maxKids
     *
     * @return integer
     */
    public function getMaxKids()
    {
        return $this->maxKids;
    }

    /**
     * Set defaultAllotment
     *
     * @param integer $defaultAllotment
     *
     * @return RsRoom
     */
    public function setDefaultAllotment($defaultAllotment)
    {
        $this->defaultAllotment = $defaultAllotment;

        return $this;
    }

    /**
     * Get defaultAllotment
     *
     * @return integer
     */
    public function getDefaultAllotment()
    {
        return $this->defaultAllotment;
    }
    

    /**
     * Set minPrice
     *
     * @param string $minPrice
     *
     * @return RsRoom
     */
    public function setMinPrice($minPrice)
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    /**
     * Get minPrice
     *
     * @return string
     */
    public function getMinPrice()
    {
        return $this->minPrice;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return RsRoom
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
     * @return RsRoom
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
     * @return RsRoom
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
     * Set baseRoom
     *
     * @param \RsBundle\Entity\RsRoom $baseRoom
     *
     * @return RsRoom
     */
    public function setBaseRoom(\RsBundle\Entity\RsRoom $baseRoom = null)
    {
        $this->baseRoom = $baseRoom;

        return $this;
    }

    /**
     * Get baseRoom
     *
     * @return \RsBundle\Entity\RsRoom
     */
    public function getBaseRoom()
    {
        return $this->baseRoom;
    }

    
    public function getTitle() {
        return $this->translate()->getTitle();
    }

    public function getDescription() {
        return $this->translate()->getDescription();
    }

    public function getDescriptionShort() {
        return $this->translate()->getDescriptionShort();
    }
    
    public function getSlug() {
        return $this->translate()->getSlug();
    }
    
    
    
    /**
     * Set singleBeds
     *
     * @param integer $singleBeds
     *
     * @return RsRoom
     */
    public function setSingleBeds($singleBeds)
    {
        $this->singleBeds = $singleBeds;

        return $this;
    }

    /**
     * Get singleBeds
     *
     * @return integer
     */
    public function getSingleBeds()
    {
        return $this->singleBeds;
    }

    /**
     * Set doubleBeds
     *
     * @param integer $doubleBeds
     *
     * @return RsRoom
     */
    public function setDoubleBeds($doubleBeds)
    {
        $this->doubleBeds = $doubleBeds;

        return $this;
    }

    /**
     * Get doubleBeds
     *
     * @return integer
     */
    public function getDoubleBeds()
    {
        return $this->doubleBeds;
    }

    /**
     * Set additionalBeds
     *
     * @param integer $additionalBeds
     *
     * @return RsRoom
     */
    public function setAdditionalBeds($additionalBeds)
    {
        $this->additionalBeds = $additionalBeds;

        return $this;
    }

    /**
     * Get additionalBeds
     *
     * @return integer
     */
    public function getAdditionalBeds()
    {
        return $this->additionalBeds;
    }

    /**
     * Set bathRooms
     *
     * @param integer $bathRooms
     *
     * @return RsRoom
     */
    public function setBathRooms($bathRooms)
    {
        $this->bathRooms = $bathRooms;

        return $this;
    }

    /**
     * Get bathRooms
     *
     * @return integer
     */
    public function getBathRooms()
    {
        return $this->bathRooms;
    }

    /**
     * Set rooms
     *
     * @param integer $rooms
     *
     * @return RsRoom
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Get rooms
     *
     * @return integer
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Set area
     *
     * @param float $area
     *
     * @return RsRoom
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return float
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Add facilityItem
     *
     * @param \RsBundle\Entity\RsFacilityItem $facilityItem
     *
     * @return RsRoom
     */
    public function addFacilityItem(\RsBundle\Entity\RsFacilityItem $facilityItem)
    {
        $this->facilityItems[] = $facilityItem;

        return $this;
    }

    /**
     * Remove facilityItem
     *
     * @param \RsBundle\Entity\RsFacilityItem $facilityItem
     */
    public function removeFacilityItem(\RsBundle\Entity\RsFacilityItem $facilityItem)
    {
        $this->facilityItems->removeElement($facilityItem);
    }

    /**
     * Get facilityItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacilityItems()
    {
        return $this->facilityItems;
    }
    





    public function getFilesDir() : string {
        return self::FILES_DIR;
    }

    public function getMainImageDir() : string {
        return self::MAIN_IMAGE_DIR;
    }


    /**
     * Set mainImage
     *
     * @param string $mainImage
     *
     * @return RsRoom
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
     * @return RsRoom
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
     * @param \RsBundle\Entity\RsRoomFile $file
     *
     * @return RsRoom
     */
    public function addFile(\RsBundle\Entity\RsRoomFile $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \RsBundle\Entity\RsRoomFile $file
     */
    public function removeFile(\RsBundle\Entity\RsRoomFile $file)
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

}
