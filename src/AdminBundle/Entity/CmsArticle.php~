<?php

namespace AdminBundle\Entity;

use APY\DataGridBundle\Grid\Mapping as Grid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Table(name="cms_article")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsArticleRepository")
 * @Vich\Uploadable()
 */
class CmsArticle
{
    use Translatable;

    const FILES_DIR = 'upload/cms_article/files/';
    const MAIN_IMAGE_DIR = 'upload/cms_article/main_image/';

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $mainImage = null;

    /**
     * @Vich\UploadableField(mapping="cms_article_main_image", fileNameProperty="mainImage")
     * @Assert\Image(maxSize="10M")
     *
     */
    protected $mainImageFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Url(checkDNS=true);
     */
    protected $link;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;
    
    /**
     * @ORM\Column(type="date", nullable=true)
     * @Grid\Column(title="Data wydarzenia")
     * @Assert\Date()
     */
    protected $date;

    /** @ORM\Column(type="string", nullable=true) */
    protected $lat;
    
    /** @ORM\Column(type="string", nullable=true) */
    protected $lng;
    
    /** @ORM\Column(type="boolean") */
    protected $isCommentAllowed = false;
    
    /** @ORM\Column(type="boolean") */
    protected $isCommentModerationRequired = false;
    
    /** @ORM\Column(type="boolean") */
    protected $isOnCalendar = false;
    
    /** @ORM\Column(type="boolean") */
    protected $isPinned = false;
    
    /** @ORM\Column(type="boolean") */
    protected $isActive = false;
    
    /**
     * @ORM\Column(type="date", nullable=false)
     * @Gedmo\Timestampable(on="create")
     * @Grid\Column(title="lbl.article_date")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;
    
    /**
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\CmsArticleCategory", inversedBy="articles", cascade={"persist"})
     * @ORM\JoinTable(name="cms_article_2_cms_article_category")
     * @Assert\Valid()
     */
    protected $categories;
    
    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\CmsArticleFile", mappedBy="article")
     */
    protected $files;
    
    
    /**---------------------------------------------------------------------------------------------------------------*/
    public function __construct()
    {
        //$this->translations = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->categories= new ArrayCollection();
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
    
    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
    
    
    public function getTitle() {
        return $this->translate()->getTitle();
    }

    public function getDescription() {
        return $this->translate()->getDescription();
    }

    public function getSlug() {
        return $this->translate()->getSlug();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lat
     *
     * @param string $lat
     *
     * @return CmsArticle
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     *
     * @return CmsArticle
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set isCommentAllowed
     *
     * @param boolean $isCommentAllowed
     *
     * @return CmsArticle
     */
    public function setIsCommentAllowed($isCommentAllowed)
    {
        $this->isCommentAllowed = $isCommentAllowed;

        return $this;
    }

    /**
     * Get isCommentAllowed
     *
     * @return boolean
     */
    public function getIsCommentAllowed()
    {
        return $this->isCommentAllowed;
    }

    /**
     * Set isCommentModerationRequired
     *
     * @param boolean $isCommentModerationRequired
     *
     * @return CmsArticle
     */
    public function setIsCommentModerationRequired($isCommentModerationRequired)
    {
        $this->isCommentModerationRequired = $isCommentModerationRequired;

        return $this;
    }

    /**
     * Get isCommentModerationRequired
     *
     * @return boolean
     */
    public function getIsCommentModerationRequired()
    {
        return $this->isCommentModerationRequired;
    }

    /**
     * Set isOnCalendar
     *
     * @param boolean $isOnCalendar
     *
     * @return CmsArticle
     */
    public function setIsOnCalendar($isOnCalendar)
    {
        $this->isOnCalendar = $isOnCalendar;

        return $this;
    }

    /**
     * Get isOnCalendar
     *
     * @return boolean
     */
    public function getIsOnCalendar()
    {
        return $this->isOnCalendar;
    }

    /**
     * Set isPinned
     *
     * @param boolean $isPinned
     *
     * @return CmsArticle
     */
    public function setIsPinned($isPinned)
    {
        $this->isPinned = $isPinned;

        return $this;
    }

    /**
     * Get isPinned
     *
     * @return boolean
     */
    public function getIsPinned()
    {
        return $this->isPinned;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return CmsArticle
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
     * @return CmsArticle
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
     * @return CmsArticle
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
     * Set mainImage
     * @param string $mainImage
     * @return CmsArticle
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CmsArticle
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add category
     *
     * @param \AdminBundle\Entity\CmsArticleCategory $category
     *
     * @return CmsArticle
     */
    public function addCategory(\AdminBundle\Entity\CmsArticleCategory $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AdminBundle\Entity\CmsArticleCategory $category
     */
    public function removeCategory(\AdminBundle\Entity\CmsArticleCategory $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     * @return CmsArticle
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
     * Add file
     *
     * @param \AdminBundle\Entity\CmsArticleFile $file
     *
     * @return CmsArticle
     */
    public function addFile(\AdminBundle\Entity\CmsArticleFile $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \AdminBundle\Entity\CmsArticleFile $file
     */
    public function removeFile(\AdminBundle\Entity\CmsArticleFile $file)
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
     * Set link
     *
     * @param string $link
     *
     * @return CmsArticle
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return CmsArticle
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
}
