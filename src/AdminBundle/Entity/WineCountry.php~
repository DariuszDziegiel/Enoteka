<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * WineCountry
 *
 * @ORM\Table(name="wine_country")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\WineCountryRepository")
 */
class WineCountry
{
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
    private $codeTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $countryCode;

    /**
     * @ORM\Column(type="integer")
     * @Gedmo\SortablePosition()
     */
    private $sort;


    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\WineCountryRegion", mappedBy="wineCountry")
     */
    private $wineCountryRegions;



    public function __construct()
    {
        $this->wineCountryRegions = new ArrayCollection();
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

    /**
     * Set codeTitle
     *
     * @param string $codeTitle
     *
     * @return WineCountry
     */
    public function setCodeTitle($codeTitle)
    {
        $this->codeTitle = $codeTitle;

        return $this;
    }

    /**
     * Get codeTitle
     *
     * @return string
     */
    public function getCodeTitle()
    {
        return $this->codeTitle;
    }

    /**
     * Add wineCountryRegion
     *
     * @param \AdminBundle\Entity\WineCountryRegion $wineCountryRegion
     *
     * @return WineCountry
     */
    public function addWineCountryRegion(\AdminBundle\Entity\WineCountryRegion $wineCountryRegion)
    {
        $this->wineCountryRegions[] = $wineCountryRegion;

        return $this;
    }

    /**
     * Remove wineCountryRegion
     *
     * @param \AdminBundle\Entity\WineCountryRegion $wineCountryRegion
     */
    public function removeWineCountryRegion(\AdminBundle\Entity\WineCountryRegion $wineCountryRegion)
    {
        $this->wineCountryRegions->removeElement($wineCountryRegion);
    }

    /**
     * Get wineCountryRegions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWineCountryRegions()
    {
        return $this->wineCountryRegions;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return WineCountry
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
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return WineCountry
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }
}
