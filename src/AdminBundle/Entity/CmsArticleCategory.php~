<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CmsArticleCategory
 * @ORM\Table(name="cms_article_category")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsArticleCategoryRepository")
 */
class CmsArticleCategory
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
     * @Assert\NotBlank()
     */
    protected $titleCode;

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
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\CmsArticle", mappedBy="categories", cascade={"persist"})
     * @ORM\JoinTable(name="cms_article_2_cms_article_category")
     * @Assert\Valid()
     */
    protected $articles;

    /**
     * @Assert\Valid()
     */
    //protected $translations;
    
    public function __construct()
    {
        $this->articles = new ArrayCollection();
        //$this->translations = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add article
     *
     * @param \AdminBundle\Entity\CmsArticle $article
     *
     * @return CmsArticleCategory
     */
    public function addArticle(\AdminBundle\Entity\CmsArticle $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \AdminBundle\Entity\CmsArticle $article
     */
    public function removeArticle(\AdminBundle\Entity\CmsArticle $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|static
     */
    public function getEvents() {
        $expr = Criteria::expr();
        $criteria = Criteria::create()
            ->orderBy(
                ['date' => Criteria::DESC]
            );
        return $this->articles->matching($criteria);
    }


    /**
     * @return \Doctrine\Common\Collections\Collection|static
     */
    public function getNews() {
        $expr = Criteria::expr();
        $criteria = Criteria::create()
            ->orderBy(
                ['createdAt' => Criteria::DESC]
            )
            ->setMaxResults(1);
        return $this->articles->matching($criteria);
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CmsArticleCategory
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
     * @return CmsArticleCategory
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
     * Set titleCode
     *
     * @param string $titleCode
     *
     * @return CmsArticleCategory
     */
    public function setTitleCode($titleCode)
    {
        $this->titleCode = $titleCode;

        return $this;
    }

    /**
     * Get titleCode
     *
     * @return string
     */
    public function getTitleCode()
    {
        return $this->titleCode;
    }


    public function getTitle() {
        return $this->translate()->getTitle();
    }

}
