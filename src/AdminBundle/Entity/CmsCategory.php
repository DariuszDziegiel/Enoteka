<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CmsCategory
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="cms_category")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsCategoryRepository")
 *
 */
class CmsCategory
{
    use Translatable;
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="boolean") */
    protected $isActive = false;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $code;
    
    /**
     * @Gedmo\TreeLevel()
     * @ORM\Column(type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight()
     * @ORM\Column(type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeLeft()
     * @ORM\Column(type="integer")
     */
    private $lft;
    
    /**
     * @Gedmo\TreeRoot()
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\CmsCategory")
     * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @Gedmo\TreeParent()
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\CmsCategory", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\CmsCategory", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\CmsPage", mappedBy="cmsCategory")
     */
    private $cmsPages;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->cmsPages = new ArrayCollection();
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
     * Set lvl
     *
     * @param integer $lvl
     *
     * @return CmsCategory
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     *
     * @return CmsCategory
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     *
     * @return CmsCategory
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set root
     *
     * @param \AdminBundle\Entity\CmsCategory $root
     *
     * @return CmsCategory
     */
    public function setRoot(\AdminBundle\Entity\CmsCategory $root = null)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return \AdminBundle\Entity\CmsCategory
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param \AdminBundle\Entity\CmsCategory $parent
     *
     * @return CmsCategory
     */
    public function setParent(\AdminBundle\Entity\CmsCategory $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AdminBundle\Entity\CmsCategory
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \AdminBundle\Entity\CmsCategory $child
     *
     * @return CmsCategory
     */
    public function addChild(\AdminBundle\Entity\CmsCategory $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AdminBundle\Entity\CmsCategory $child
     */
    public function removeChild(\AdminBundle\Entity\CmsCategory $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return CmsCategory
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
     * @return CmsCategory
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
     * @return CmsCategory
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
     * Add cmsPage
     *
     * @param \AdminBundle\Entity\CmsPage $cmsPage
     *
     * @return CmsCategory
     */
    public function addCmsPage(\AdminBundle\Entity\CmsPage $cmsPage)
    {
        $this->cmsPages[] = $cmsPage;

        return $this;
    }

    /**
     * Remove cmsPage
     *
     * @param \AdminBundle\Entity\CmsPage $cmsPage
     */
    public function removeCmsPage(\AdminBundle\Entity\CmsPage $cmsPage)
    {
        $this->cmsPages->removeElement($cmsPage);
    }

    /**
     * Get cmsPages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCmsPages()
    {
        return $this->cmsPages;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return CmsCategory
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
}
