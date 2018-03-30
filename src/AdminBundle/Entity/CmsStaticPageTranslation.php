<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;


/**
 * CmsStaticPageTranslation
 * @ORM\Entity()
 * @ORM\Table(name="cms_static_page_translation")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsStaticPageTranslationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CmsStaticPageTranslation
{
    use ORMBehaviors\Translatable\Translation;
    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $subTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionShort;
    
    
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $seoTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $seoKeywords;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $seoDescription;


    /**
     * Set title
     *
     * @param string $title
     *
     * @return CmsStaticPageTranslation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CmsStaticPageTranslation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return CmsStaticPageTranslation
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @ORM\PostUpdate()
     */
    protected function postUpdate() {
        $this->getTranslatable()->setUpdatedAt(new \DateTime());
    }





    /**
     * Set seoTitle
     *
     * @param string $seoTitle
     *
     * @return CmsStaticPageTranslation
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;

        return $this;
    }

    /**
     * Get seoTitle
     *
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    /**
     * Set seoKeywords
     *
     * @param string $seoKeywords
     *
     * @return CmsStaticPageTranslation
     */
    public function setSeoKeywords($seoKeywords)
    {
        $this->seoKeywords = $seoKeywords;

        return $this;
    }

    /**
     * Get seoKeywords
     *
     * @return string
     */
    public function getSeoKeywords()
    {
        return $this->seoKeywords;
    }

    /**
     * Set seoDescription
     *
     * @param string $seoDescription
     *
     * @return CmsStaticPageTranslation
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seoDescription = $seoDescription;

        return $this;
    }

    /**
     * Get seoDescription
     *
     * @return string
     */
    public function getSeoDescription()
    {
        return $this->seoDescription;
    }

    /**
     * Set subTitle
     *
     * @param string $subTitle
     *
     * @return CmsStaticPageTranslation
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    /**
     * Get subTitle
     *
     * @return string
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * Set descriptionShort
     *
     * @param string $descriptionShort
     *
     * @return CmsStaticPageTranslation
     */
    public function setDescriptionShort($descriptionShort)
    {
        $this->descriptionShort = $descriptionShort;

        return $this;
    }

    /**
     * Get descriptionShort
     *
     * @return string
     */
    public function getDescriptionShort()
    {
        return $this->descriptionShort;
    }
}
