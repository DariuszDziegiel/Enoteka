<?php

namespace AdminBundle\Entity;

use APY\DataGridBundle\Grid\Mapping\Column;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CmsLanguage
 *
 * @ORM\Table(name="cms_language")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsLanguageRepository")
 */
class CmsLanguage
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Column(title="Nazwa")
     */
    protected $title;

    /**
     * @ORM\Column(type="string")
     */
    protected $code;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $codeLocale;

    /**
     * @ORM\Column(type="boolean")
     * @Column(title="Aktywny w panelu administratora")
     */
    protected $isActive = false;


    /**
     * @ORM\Column(type="boolean")
     * @Column(title="Aktywny na stronie")
     */
    private $isActiveOnPage = true;
    

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
     * @return CmsLanguage
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
     * Set code
     *
     * @param string $code
     *
     * @return CmsLanguage
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set codeLocale
     *
     * @param string $codeLocale
     *
     * @return CmsLanguage
     */
    public function setCodeLocale($codeLocale)
    {
        $this->codeLocale = $codeLocale;

        return $this;
    }

    /**
     * Get codeLocale
     *
     * @return string
     */
    public function getCodeLocale()
    {
        return $this->codeLocale;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return CmsLanguage
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
     * Set isActiveOnPage
     *
     * @param boolean $isActiveOnPage
     *
     * @return CmsLanguage
     */
    public function setIsActiveOnPage($isActiveOnPage)
    {
        $this->isActiveOnPage = $isActiveOnPage;

        return $this;
    }

    /**
     * Get isActiveOnPage
     *
     * @return boolean
     */
    public function getIsActiveOnPage()
    {
        return $this->isActiveOnPage;
    }
}
