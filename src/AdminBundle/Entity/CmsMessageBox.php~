<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * CmsMessageBox
 *
 * @ORM\Table(name="cms_message_box")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CmsMessageBoxRepository")
 */
class CmsMessageBox
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User", inversedBy="fromMessages")
     */
    private $fromUser;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User", inversedBy="toMessages")
     */
    private $toUser;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isShowed = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRead = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isImportant = false;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return CmsMessageBox
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CmsMessageBox
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
     * Set isShowed
     *
     * @param boolean $isShowed
     *
     * @return CmsMessageBox
     */
    public function setIsShowed($isShowed)
    {
        $this->isShowed = $isShowed;

        return $this;
    }

    /**
     * Get isShowed
     *
     * @return boolean
     */
    public function getIsShowed()
    {
        return $this->isShowed;
    }

    /**
     * Set isRead
     *
     * @param boolean $isRead
     *
     * @return CmsMessageBox
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead
     *
     * @return boolean
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * Set isImportant
     *
     * @param boolean $isImportant
     *
     * @return CmsMessageBox
     */
    public function setIsImportant($isImportant)
    {
        $this->isImportant = $isImportant;

        return $this;
    }

    /**
     * Get isImportant
     *
     * @return boolean
     */
    public function getIsImportant()
    {
        return $this->isImportant;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return CmsMessageBox
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
     * Set fromUser
     *
     * @param \AdminBundle\Entity\User $fromUser
     *
     * @return CmsMessageBox
     */
    public function setFromUser(\AdminBundle\Entity\User $fromUser = null)
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    /**
     * Get fromUser
     *
     * @return \AdminBundle\Entity\User
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * Set toUser
     *
     * @param \AdminBundle\Entity\User $toUser
     *
     * @return CmsMessageBox
     */
    public function setToUser(\AdminBundle\Entity\User $toUser = null)
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * Get toUser
     *
     * @return \AdminBundle\Entity\User
     */
    public function getToUser()
    {
        return $this->toUser;
    }
}
