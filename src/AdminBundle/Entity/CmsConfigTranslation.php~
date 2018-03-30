<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * @ORM\Table(name="cms_config_translation")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsConfigTranslationRepository")
 */
class CmsConfigTranslation
{
    use Translation;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $configDescription;

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
     * Set configDescription
     *
     * @param string $configDescription
     *
     * @return CmsConfigTranslation
     */
    public function setConfigDescription($configDescription)
    {
        $this->configDescription = $configDescription;

        return $this;
    }

    /**
     * Get configDescription
     *
     * @return string
     */
    public function getConfigDescription()
    {
        return $this->configDescription;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CmsConfigTranslation
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
     * @return CmsConfigTranslation
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
}
