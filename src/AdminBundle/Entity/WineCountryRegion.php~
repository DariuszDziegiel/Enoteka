<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * WineCountryRegion
 *
 * @ORM\Table(name="wine_country_region")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\WineCountryRegionRepository")
 */
class WineCountryRegion
{
    use Translatable;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\WineCountry", inversedBy="wineCountryRegions")
     */
    private $wineCountry;

    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\WineCountrySubregion", mappedBy="wineCountryRegion")
     */
    private $wineCountrySubregions;


    public function __construct()
    {
        $this->wineCountrySubregions = new ArrayCollection();
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return WineCountryRegion
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
     * @return WineCountryRegion
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
     * Set wineCountry
     *
     * @param \AdminBundle\Entity\WineCountry $wineCountry
     *
     * @return WineCountryRegion
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
     * Add wineCountrySubregion
     *
     * @param \AdminBundle\Entity\WineCountrySubregion $wineCountrySubregion
     *
     * @return WineCountryRegion
     */
    public function addWineCountrySubregion(\AdminBundle\Entity\WineCountrySubregion $wineCountrySubregion)
    {
        $this->wineCountrySubregions[] = $wineCountrySubregion;

        return $this;
    }

    /**
     * Remove wineCountrySubregion
     *
     * @param \AdminBundle\Entity\WineCountrySubregion $wineCountrySubregion
     */
    public function removeWineCountrySubregion(\AdminBundle\Entity\WineCountrySubregion $wineCountrySubregion)
    {
        $this->wineCountrySubregions->removeElement($wineCountrySubregion);
    }

    /**
     * Get wineCountrySubregions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWineCountrySubregions()
    {
        return $this->wineCountrySubregions;
    }
}
