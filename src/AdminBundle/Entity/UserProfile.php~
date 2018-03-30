<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserProfile
 *
 * @ORM\Table(name="user_profile")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\UserProfileRepository")
 */
class UserProfile
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"ProfileEdit", "Registration"})
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"ProfileEdit", "Registration"})
     */
    private $surname;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"ProfileEdit", "Registration"})
     */
    private $address;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"ProfileEdit", "Registration"})
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"ProfileEdit", "Registration"})
     */
    private $zip;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"ProfileEdit", "Registration"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $companyNip;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEmailMarketingAgreement = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEmailMarketingDataProcessingAgreement = false;
    
    /**
     * @ORM\OneToOne(targetEntity="AdminBundle\Entity\User", inversedBy="userProfile")
     * @ORM\JoinColumn(onDelete="CASCADE", )
     */
    private $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     * @param string $name
     * @return UserProfile
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return UserProfile
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return UserProfile
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return UserProfile
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zip
     *
     * @param string $zip
     *
     * @return UserProfile
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return UserProfile
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    
    /**
     * Set companyName
     *
     * @param string $companyName
     *
     * @return UserProfile
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set companyNip
     *
     * @param string $companyNip
     *
     * @return UserProfile
     */
    public function setCompanyNip($companyNip)
    {
        $this->companyNip = $companyNip;

        return $this;
    }

    /**
     * Get companyNip
     *
     * @return string
     */
    public function getCompanyNip()
    {
        return $this->companyNip;
    }

    /**
     * Set user
     *
     * @param \AdminBundle\Entity\User $user
     *
     * @return UserProfile
     */
    public function setUser(\AdminBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AdminBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set isEmailMarketingAgreement
     *
     * @param boolean $isEmailMarketingAgreement
     *
     * @return UserProfile
     */
    public function setIsEmailMarketingAgreement($isEmailMarketingAgreement)
    {
        $this->isEmailMarketingAgreement = $isEmailMarketingAgreement;

        return $this;
    }

    /**
     * Get isEmailMarketingAgreement
     *
     * @return boolean
     */
    public function getIsEmailMarketingAgreement()
    {
        return $this->isEmailMarketingAgreement;
    }

    /**
     * Set isEmailMarketingDataProcessingAgreement
     *
     * @param boolean $isEmailMarketingDataProcessingAgreement
     *
     * @return UserProfile
     */
    public function setIsEmailMarketingDataProcessingAgreement($isEmailMarketingDataProcessingAgreement)
    {
        $this->isEmailMarketingDataProcessingAgreement = $isEmailMarketingDataProcessingAgreement;

        return $this;
    }

    /**
     * Get isEmailMarketingDataProcessingAgreement
     *
     * @return boolean
     */
    public function getIsEmailMarketingDataProcessingAgreement()
    {
        return $this->isEmailMarketingDataProcessingAgreement;
    }
}
