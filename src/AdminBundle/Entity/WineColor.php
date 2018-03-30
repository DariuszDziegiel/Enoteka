<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WineColor
 *
 * @ORM\Table(name="wine_color")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\WineColorRepository")
 */
class WineColor
{
    use Translatable;
    
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
    private $codeTitle;

    /**
     * @ORM\Column(type="integer")
     * @Gedmo\SortablePosition()
     */
    private $sort;

    
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
     * @return WineColor
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
     * Set sort
     *
     * @param integer $sort
     *
     * @return WineColor
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
}
