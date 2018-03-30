<?php

namespace RsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * RsFacilityItemTranslation
 *
 * @ORM\Table(name="rs_facility_item_translation")
 * @ORM\Entity(repositoryClass="RsBundle\Repository\RsFacilityItemTranslationRepository")
 */
class RsFacilityItemTranslation
{
    use Translation;
    
    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    protected $title;

    /** @ORM\Column(type="text", nullable=true) */
    protected $description;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    protected $slug;





    /**
     * Set title
     *
     * @param string $title
     *
     * @return RsFacilityItemTranslation
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
     * @return RsFacilityItemTranslation
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
     * @return RsFacilityItemTranslation
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
}
