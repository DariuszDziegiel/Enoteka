<?php

namespace RsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="rs_meal")
 * @ORM\Entity(repositoryClass="RsBundle\Repository\RsMealRepository")
 */
class RsMeal
{
    use Translatable;
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @GRID\Column(title="lbl.is_active");
     */
    private $isActive = false;

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
     * @ORM\OneToMany(targetEntity="RsBundle\Entity\RsPackage",mappedBy="rsMeal")
     */
    //private $rsPackages;

    /**
     * @Assert\Valid()
     */
    protected $translations;

    //-------------------------------------------------------------------------------------------------------------------


    public function __construct()
    {

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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return RsMeal
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
     * @return RsMeal
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
     * @return RsMeal
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



    public function getTitle() {
        return $this->translate()->getTitle();
    }

    public function getDescription() {
        return $this->translate()->getDescription();
    }


    /**
     * Add rsPackage
     *
     * @param \RsBundle\Entity\RsPackage $rsPackage
     *
     * @return RsMeal
     */
    public function addRsPackage(\RsBundle\Entity\RsPackage $rsPackage)
    {
        $this->rsPackages[] = $rsPackage;

        return $this;
    }

    /**
     * Remove rsPackage
     *
     * @param \RsBundle\Entity\RsPackage $rsPackage
     */
    public function removeRsPackage(\RsBundle\Entity\RsPackage $rsPackage)
    {
        $this->rsPackages->removeElement($rsPackage);
    }

    /**
     * Get rsPackages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRsPackages()
    {
        return $this->rsPackages;
    }
}
