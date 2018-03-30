<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WineCountrySubregion
 *
 * @ORM\Table(name="wine_country_subregion")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\WineCountrySubregionRepository")
 */
class WineCountrySubregion
{
    /**
     * @var int
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
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\WineCountryRegion", inversedBy="wineCountrySubregions")
     */
    private $wineCountryRegion;
    
    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\Wine", mappedBy="wineCountrySubregion")
     */
    private $wines;


    public function __construct()
    {
        $this->wines = new ArrayCollection();
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

    /**
     * Set title
     *
     * @param string $title
     *
     * @return WineCountrySubregion
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
     * Set wineCountry
     *
     * @param \AdminBundle\Entity\WineCountry $wineCountry
     *
     * @return WineCountrySubregion
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
     * @return WineCountrySubregion
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
     * Add wine
     *
     * @param \AdminBundle\Entity\Wine $wine
     *
     * @return WineCountrySubregion
     */
    public function addWine(\AdminBundle\Entity\Wine $wine)
    {
        $this->wines[] = $wine;

        return $this;
    }

    /**
     * Remove wine
     *
     * @param \AdminBundle\Entity\Wine $wine
     */
    public function removeWine(\AdminBundle\Entity\Wine $wine)
    {
        $this->wines->removeElement($wine);
    }

    /**
     * Get wines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWines()
    {
        return $this->wines;
    }
}
