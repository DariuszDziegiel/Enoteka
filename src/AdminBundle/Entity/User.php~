<?php

namespace AdminBundle\Entity;

use APY\DataGridBundle\Grid\Mapping\Column;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * USer
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\UserRepository")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $username;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096, min=6)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email(checkHost=true)
     * @Assert\NotBlank()
     */
    private $email;

    /** @ORM\Column(type="string", nullable=true) */
    private $passwordResetHash;

    /** @ORM\Column(type="string", nullable=true) */
    private $activationHash;

    /** @ORM\Column(type="string", nullable=true) */
    private $salt;

    /** @ORM\Column(type="boolean", nullable=false) **/
    private $isActive = 0;

    /** @ORM\Column(type="boolean", nullable=false) */
    private $isDefaultPasswordChanged = 0;

    /**
     * 1 - działalność gospodarcza, 2 - osoba fizyczna
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank(message="Określ formę konta")
     */
    private $userType;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $facebookID;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $googleID;


    /**
     * @ORM\Column(type="boolean")
     */
    private $isNewSocialAccount = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSocialAccount = 0;


    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\UserGroup", inversedBy="users")
     * @Assert\NotBlank(message="valid.userGroup")
     */
    private $userGroup;

    /**
     * @Assert\Valid()
     * @ORM\OneToOne(targetEntity="AdminBundle\Entity\UserProfile", mappedBy="user", cascade={"persist"})
     */
    private $userProfile;


    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\CmsMessageBox", mappedBy="fromUser")
     */
    private $fromMessages;

    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\CmsMessageBox", mappedBy="toUser")
     */
    private $toMessages;


    
    
    public function __construct()
    {
        $this->fromMessages = new ArrayCollection();
        $this->toMessages = new ArrayCollection();
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return array($this->getUserGroup()->getRole());
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }
    
    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set passwordResetHash
     *
     * @param string $passwordResetHash
     *
     * @return User
     */
    public function setPasswordResetHash($passwordResetHash)
    {
        $this->passwordResetHash = $passwordResetHash;

        return $this;
    }

    /**
     * Get passwordResetHash
     *
     * @return string
     */
    public function getPasswordResetHash()
    {
        return $this->passwordResetHash;
    }

    /**
     * Set activationHash
     *
     * @param string $activationHash
     *
     * @return User
     */
    public function setActivationHash($activationHash)
    {
        $this->activationHash = $activationHash;

        return $this;
    }

    /**
     * Get activationHash
     *
     * @return string
     */
    public function getActivationHash()
    {
        return $this->activationHash;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
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
     * Set group
     *
     * @param \AdminBundle\Entity\UserGroup $group
     *
     * @return User
     */
    public function setGroup(\AdminBundle\Entity\UserGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AdminBundle\Entity\UserGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set userGroup
     *
     * @param \AdminBundle\Entity\UserGroup $userGroup
     *
     * @return User
     */
    public function setUserGroup(\AdminBundle\Entity\UserGroup $userGroup = null)
    {
        $this->userGroup = $userGroup;

        return $this;
    }

    /**
     * Get userGroup
     *
     * @return \AdminBundle\Entity\UserGroup
     */
    public function getUserGroup()
    {
        return $this->userGroup;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Add userGroup
     *
     * @param \AdminBundle\Entity\UserGroup $userGroup
     *
     * @return User
     */
    public function addUserGroup(\AdminBundle\Entity\UserGroup $userGroup)
    {
        $this->userGroup[] = $userGroup;

        return $this;
    }

    /**
     * Remove userGroup
     *
     * @param \AdminBundle\Entity\UserGroup $userGroup
     */
    public function removeUserGroup(\AdminBundle\Entity\UserGroup $userGroup)
    {
        $this->userGroup->removeElement($userGroup);
    }

    /**
     * Set isDefaultPasswordChanged
     *
     * @param boolean $isDefaultPasswordChanged
     *
     * @return User
     */
    public function setIsDefaultPasswordChanged($isDefaultPasswordChanged)
    {
        $this->isDefaultPasswordChanged = $isDefaultPasswordChanged;

        return $this;
    }

    /**
     * Get isDefaultPasswordChanged
     *
     * @return boolean
     */
    public function getIsDefaultPasswordChanged()
    {
        return $this->isDefaultPasswordChanged;
    }




    /**
     * Set userProfile
     *
     * @param \AdminBundle\Entity\UserProfile $userProfile
     *
     * @return User
     */
    public function setUserProfile(\AdminBundle\Entity\UserProfile $userProfile = null)
    {
        $this->userProfile = $userProfile;
        $userProfile->setUser($this);

        return $this;
    }

    /**
     * Get userProfile
     *
     * @return \AdminBundle\Entity\UserProfile
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * Set userType
     *
     * @param integer $userType
     *
     * @return User
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType
     *
     * @return integer
     */
    public function getUserType()
    {
        return $this->userType;
    }


    public function setPlainPassword($password) {
        $this->plainPassword = $password;
    }

    public function getPlainPassword() {
        return $this->plainPassword;
    }









    /**
     * Add fromMessage
     *
     * @param \AdminBundle\Entity\CmsMessageBox $fromMessage
     *
     * @return User
     */
    public function addFromMessage(\AdminBundle\Entity\CmsMessageBox $fromMessage)
    {
        $this->fromMessages[] = $fromMessage;

        return $this;
    }

    /**
     * Remove fromMessage
     *
     * @param \AdminBundle\Entity\CmsMessageBox $fromMessage
     */
    public function removeFromMessage(\AdminBundle\Entity\CmsMessageBox $fromMessage)
    {
        $this->fromMessages->removeElement($fromMessage);
    }

    /**
     * Get fromMessages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFromMessages()
    {
        return $this->fromMessages;
    }

    /**
     * Add toMessage
     *
     * @param \AdminBundle\Entity\CmsMessageBox $toMessage
     *
     * @return User
     */
    public function addToMessage(\AdminBundle\Entity\CmsMessageBox $toMessage)
    {
        $this->toMessages[] = $toMessage;

        return $this;
    }

    /**
     * Remove toMessage
     *
     * @param \AdminBundle\Entity\CmsMessageBox $toMessage
     */
    public function removeToMessage(\AdminBundle\Entity\CmsMessageBox $toMessage)
    {
        $this->toMessages->removeElement($toMessage);
    }

    /**
     * Get toMessages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getToMessages()
    {
        return $this->toMessages;
    }





    /**
     * Set facebookID
     *
     * @param string $facebookID
     *
     * @return User
     */
    public function setFacebookID($facebookID)
    {
        $this->facebookID = $facebookID;

        return $this;
    }

    /**
     * Get facebookID
     *
     * @return string
     */
    public function getFacebookID()
    {
        return $this->facebookID;
    }

    /**
     * Set googleID
     *
     * @param string $googleID
     *
     * @return User
     */
    public function setGoogleID($googleID)
    {
        $this->googleID = $googleID;

        return $this;
    }

    /**
     * Get googleID
     *
     * @return string
     */
    public function getGoogleID()
    {
        return $this->googleID;
    }

    /**
     * Set isNewSocialAccount
     *
     * @param boolean $isNewSocialAccount
     *
     * @return User
     */
    public function setIsNewSocialAccount($isNewSocialAccount)
    {
        $this->isNewSocialAccount = $isNewSocialAccount;

        return $this;
    }

    /**
     * Get isNewSocialAccount
     *
     * @return boolean
     */
    public function getIsNewSocialAccount()
    {
        return $this->isNewSocialAccount;
    }

    /**
     * Set isSocialAccount
     *
     * @param boolean $isSocialAccount
     *
     * @return User
     */
    public function setIsSocialAccount($isSocialAccount)
    {
        $this->isSocialAccount = $isSocialAccount;

        return $this;
    }

    /**
     * Get isSocialAccount
     *
     * @return boolean
     */
    public function getIsSocialAccount()
    {
        return $this->isSocialAccount;
    }
}
