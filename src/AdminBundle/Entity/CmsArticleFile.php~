<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CmsArticleFile
 * @ORM\Table(name="cms_article_file")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsArticleFileRepository")
 */
class CmsArticleFile
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $originalFilename;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(choices="{'img', 'doc', 'video'}")
     */
    private $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $mimeType;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\CmsArticle", inversedBy="files")
     */
    protected $article;

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
     * @param string $filename
     */
    public function setFilename($filename) 
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Get filename
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set createdAt
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt) 
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     * @param \DateTime $updatedAt
     * @return CmsArticleFile
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set article
     * @param CmsArticle $article
     * @return CmsArticleFile
     */
    public function setArticle(\AdminBundle\Entity\CmsArticle $article = null)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * Get article
     */
    public function getArticle() 
    {
        return $this->article;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return CmsArticleFile
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
     * Set extension
     *
     * @param string $extension
     *
     * @return CmsArticleFile
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return CmsArticleFile
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set originalFilename
     *
     * @param string $originalFilename
     *
     * @return CmsArticleFile
     */
    public function setOriginalFilename($originalFilename)
    {
        $this->originalFilename = $originalFilename;

        return $this;
    }

    /**
     * Get originalFilename
     *
     * @return string
     */
    public function getOriginalFilename()
    {
        return $this->originalFilename;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return CmsArticleFile
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }
}
