<?php

namespace RsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * RsConfigTranslation
 *
 * @ORM\Table(name="rs_config_translation")
 * @ORM\Entity(repositoryClass="RsBundle\Repository\RsConfigTranslationRepository")
 */
class RsConfigTranslation
{
    use Translation;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"basic_data"})
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank(groups={"basic_data"})
     * */
    protected $description;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $descriptionRegulations;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $descriptionReservationRegulations;

    /**
     * Set title
     *
     * @param string $title
     *
     * @return RsConfigTranslation
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
     * @return RsConfigTranslation
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
     * Set descriptionRegulations
     *
     * @param string $descriptionRegulations
     *
     * @return RsConfigTranslation
     */
    public function setDescriptionRegulations($descriptionRegulations)
    {
        $this->descriptionRegulations = $descriptionRegulations;

        return $this;
    }

    /**
     * Get descriptionRegulations
     *
     * @return string
     */
    public function getDescriptionRegulations()
    {
        return $this->descriptionRegulations;
    }

    /**
     * Set descriptionReservationRegulations
     *
     * @param string $descriptionReservationRegulations
     *
     * @return RsConfigTranslation
     */
    public function setDescriptionReservationRegulations($descriptionReservationRegulations)
    {
        $this->descriptionReservationRegulations = $descriptionReservationRegulations;

        return $this;
    }

    /**
     * Get descriptionReservationRegulations
     *
     * @return string
     */
    public function getDescriptionReservationRegulations()
    {
        return $this->descriptionReservationRegulations;
    }
}
