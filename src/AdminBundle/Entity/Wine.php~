<?php

namespace AdminBundle\Entity;

use APY\DataGridBundle\Grid\Mapping\Column;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Wine
 * @ORM\Table(name="wine")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\WineRepository")
 */
class Wine
{
    use Translatable;
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $title;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Length(min="4")
     * @Column(title="Rocznik")
     */
    private $year;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Column(title="Cena 2,5 CL")
     * @Assert\Range(min="0")
     */
    private $price2comma5cl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Column(title="Cena 5 CL")
     * @Assert\Range(min="0")
     */
    private $price5cl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Column(title="Cena 10 CL")
     * @Assert\Range(min="0")
     */
    private $price10cl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Column(title="Cena 75 CL")
     * @Assert\Range(min="0")
     */
    private $price75cl;
    
    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\WineMaturity")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $wineMaturity;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\WineColor")
     * @Assert\NotBlank()
     */
    private $wineColor;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\WineCountry")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $wineCountry;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\WineCountryRegion")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $wineCountryRegion;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\WineCountrySubregion", inversedBy="wines")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $wineCountrySubregion;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Wine
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }
    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Wine
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
     * @return Wine
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
     * Set wineMaturity
     *
     * @param \AdminBundle\Entity\WineMaturity $wineMaturity
     *
     * @return Wine
     */
    public function setWineMaturity(\AdminBundle\Entity\WineMaturity $wineMaturity = null)
    {
        $this->wineMaturity = $wineMaturity;

        return $this;
    }

    /**
     * Get wineMaturity
     *
     * @return \AdminBundle\Entity\WineMaturity
     */
    public function getWineMaturity()
    {
        return $this->wineMaturity;
    }

    /**
     * Set wineColor
     *
     * @param \AdminBundle\Entity\WineColor $wineColor
     *
     * @return Wine
     */
    public function setWineColor(\AdminBundle\Entity\WineColor $wineColor = null)
    {
        $this->wineColor = $wineColor;

        return $this;
    }

    /**
     * Get wineColor
     *
     * @return \AdminBundle\Entity\WineColor
     */
    public function getWineColor()
    {
        return $this->wineColor;
    }

    /**
     * Set wineCountry
     *
     * @param \AdminBundle\Entity\WineCountry $wineCountry
     *
     * @return Wine
     */
    public function setWineCountry(\AdminBundle\Entity\WineCountry $wineCountry = null)
    {
        $this->wineCountry = $wineCountry;

        return $this;
    }

    /**
     * Get wineCountry
     *
     * @return \AdminBundle\Entity\WineCountry
     */
    public function getWineCountry()
    {
        return $this->wineCountry;
    }

    /**
     * Set wineCountryRegion
     *
     * @param \AdminBundle\Entity\WineCountryRegion $wineCountryRegion
     *
     * @return Wine
     */
    public function setWineCountryRegion(\AdminBundle\Entity\WineCountryRegion $wineCountryRegion = null)
    {
        $this->wineCountryRegion = $wineCountryRegion;

        return $this;
    }

    /**
     * Get wineCountryRegion
     *
     * @return \AdminBundle\Entity\WineCountryRegion
     */
    public function getWineCountryRegion()
    {
        return $this->wineCountryRegion;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Wine
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
     * Set wineCountrySubregion
     *
     * @param \AdminBundle\Entity\WineCountrySubregion $wineCountrySubregion
     *
     * @return Wine
     */
    public function setWineCountrySubregion(\AdminBundle\Entity\WineCountrySubregion $wineCountrySubregion = null)
    {
        $this->wineCountrySubregion = $wineCountrySubregion;

        return $this;
    }

    /**
     * Get wineCountrySubregion
     *
     * @return \AdminBundle\Entity\WineCountrySubregion
     */
    public function getWineCountrySubregion()
    {
        return $this->wineCountrySubregion;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Wine
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
     * Set price10cl
     *
     * @param string $price10cl
     *
     * @return Wine
     */
    public function setPrice10cl($price10cl)
    {
        $this->price10cl = $price10cl;

        return $this;
    }

    /**
     * Get price10cl
     *
     * @return string
     */
    public function getPrice10cl()
    {
        return $this->price10cl;
    }

    /**
     * Set price75cl
     *
     * @param string $price75cl
     *
     * @return Wine
     */
    public function setPrice75cl($price75cl)
    {
        $this->price75cl = $price75cl;

        return $this;
    }

    /**
     * Get price75cl
     *
     * @return string
     */
    public function getPrice75cl()
    {
        return $this->price75cl;
    }

    /**
     * Set price5cl
     *
     * @param string $price5cl
     *
     * @return Wine
     */
    public function setPrice5cl($price5cl)
    {
        $this->price5cl = $price5cl;

        return $this;
    }

    /**
     * Get price5cl
     *
     * @return string
     */
    public function getPrice5cl()
    {
        return $this->price5cl;
    }

    /**
     * Set price2comma5cl
     *
     * @param integer $price2comma5cl
     *
     * @return Wine
     */
    public function setPrice2comma5cl($price2comma5cl)
    {
        $this->price2comma5cl = $price2comma5cl;

        return $this;
    }

    /**
     * Get price2comma5cl
     *
     * @return integer
     */
    public function getPrice2comma5cl()
    {
        return $this->price2comma5cl;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Wine
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
}
