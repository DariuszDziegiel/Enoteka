<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WineMaturity
 *
 * @ORM\Table(name="wine_maturity")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\WineMaturityRepository")
 */
class WineMaturity
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
     * @Assert\NotBlank();
     */
    private $codeTitle;
    
    public function __construct()
    {
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codeTitle
     *
     * @param string $codeTitle
     *
     * @return WineMaturity
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
}
