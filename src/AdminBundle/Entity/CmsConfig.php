<?php
namespace AdminBundle\Entity;

use APY\DataGridBundle\Grid\Mapping\Column;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * CmsConfig
 * @ORM\Table(name="cms_config")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsConfigRepository")
 * @Vich\Uploadable()
 */
class CmsConfig
{
    const FILES_DIR = 'upload/cms_config/';

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
    private $configGroup;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $configKey;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $configValue;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Column(title="Nazwa")
     */
    private $configTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $configType;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image = null;

    /**
     * @Vich\UploadableField(mapping="cms_config_image", fileNameProperty="image")
     * @Assert\Image(maxSize="10M")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $attachment;

    /**
     * @Vich\UploadableField(mapping="cms_config_file", fileNameProperty="attachment")
     * @Assert\File(mimeTypes={"application/pdf"})
     */
    private $attachmentFile;



    /**
     * @ORM\Column(type="boolean")
     */
    private $isTranslatable = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isHasImage = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isHasAttachment = false;


    /**
     * @Assert\Valid()
     */
    //protected $translations;
    
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

    
    
 
    public function __construct()
    {
        //$this->translations  = new ArrayCollection();
    }
    
    public function getConfigDescription() {
        return $this->translate()->getConfigDescription();
    }

    public function getFilesDir() {
        return self::FILES_DIR;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     * @return CmsConfig
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


    public function setAttachmentFile(File $file = null)
    {
        $this->attachmentFile = $file;
        if ($file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    public function getAttachmentFile()
    {
        return $this->attachmentFile;
    }



    /**
     * Get id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set configKey
     * @param string $configKey
     * @return CmsConfig
     */
    public function setConfigKey($configKey)
    {
        $this->configKey = $configKey;
        return $this;
    }

    /**
     * Get configKey
     * @return string
     */
    public function getConfigKey()
    {
        return $this->configKey;
    }

    /**
     * Set configValue
     * @param string $configValue
     * @return CmsConfig
     */
    public function setConfigValue($configValue)
    {
        $this->configValue = $configValue;

        return $this;
    }

    /**
     * Get configValue
     * @return string
     */
    public function getConfigValue()
    {
        return $this->configValue;
    }

    /**
     * Set createdAt
     * @param \DateTime $createdAt
     * @return CmsConfig
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
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
     * @return CmsConfig
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
     * Set configGroup
     *
     * @param string $configGroup
     *
     * @return CmsConfig
     */
    public function setConfigGroup($configGroup)
    {
        $this->configGroup = $configGroup;

        return $this;
    }

    /**
     * Get configGroup
     *
     * @return string
     */
    public function getConfigGroup()
    {
        return $this->configGroup;
    }

    /**
     * Set configTitle
     *
     * @param string $configTitle
     *
     * @return CmsConfig
     */
    public function setConfigTitle($configTitle)
    {
        $this->configTitle = $configTitle;

        return $this;
    }

    /**
     * Get configTitle
     *
     * @return string
     */
    public function getConfigTitle()
    {
        return $this->configTitle;
    }

    /**
     * Set configType
     *
     * @param string $configType
     *
     * @return CmsConfig
     */
    public function setConfigType($configType)
    {
        $this->configType = $configType;

        return $this;
    }

    /**
     * Get configType
     *
     * @return string
     */
    public function getConfigType()
    {
        return $this->configType;
    }

    /**
     * Set isTranslatable
     *
     * @param boolean $isTranslatable
     *
     * @return CmsConfig
     */
    public function setIsTranslatable($isTranslatable)
    {
        $this->isTranslatable = $isTranslatable;

        return $this;
    }

    /**
     * Get isTranslatable
     *
     * @return boolean
     */
    public function getIsTranslatable()
    {
        return $this->isTranslatable;
    }

    /**
     * Set minNumberValue
     *
     * @param string $minNumberValue
     *
     * @return CmsConfig
     */
    public function setMinNumberValue($minNumberValue)
    {
        $this->minNumberValue = $minNumberValue;

        return $this;
    }

    /**
     * Get minNumberValue
     *
     * @return string
     */
    public function getMinNumberValue()
    {
        return $this->minNumberValue;
    }

    /**
     * Set maxNumberValue
     *
     * @param string $maxNumberValue
     *
     * @return CmsConfig
     */
    public function setMaxNumberValue($maxNumberValue)
    {
        $this->maxNumberValue = $maxNumberValue;

        return $this;
    }

    /**
     * Get maxNumberValue
     *
     * @return string
     */
    public function getMaxNumberValue()
    {
        return $this->maxNumberValue;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return CmsConfig
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
     * Set isHasImage
     *
     * @param boolean $isHasImage
     *
     * @return CmsConfig
     */
    public function setIsHasImage($isHasImage)
    {
        $this->isHasImage = $isHasImage;

        return $this;
    }

    /**
     * Get isHasImage
     *
     * @return boolean
     */
    public function getIsHasImage()
    {
        return $this->isHasImage;
    }

    /**
     * Set attachment
     *
     * @param string $attachment
     *
     * @return CmsConfig
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * Get attachment
     *
     * @return string
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set isHasAttachment
     *
     * @param boolean $isHasAttachment
     *
     * @return CmsConfig
     */
    public function setIsHasAttachment($isHasAttachment)
    {
        $this->isHasAttachment = $isHasAttachment;

        return $this;
    }

    /**
     * Get isHasAttachment
     *
     * @return boolean
     */
    public function getIsHasAttachment()
    {
        return $this->isHasAttachment;
    }
}
