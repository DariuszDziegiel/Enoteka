<?php

namespace RsBundle\Entity;

use APY\DataGridBundle\Grid\Mapping\Column;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * RsConfig
 *
 * @ORM\Table(name="rs_config")
 * @ORM\Entity(repositoryClass="RsBundle\Repository\RsConfigRepository")
 */
class RsConfig
{
    use Translatable;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    //---------------------------------adress----------------------------------------------------------------------
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"address"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"address"})
     */
    private $street;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"address"})
     */
    private $zip;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Country(groups={"address"})
     */
    private $country;

    //---------------------contact----------------------------------------------
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"contact"})
     * @Assert\Email(groups={"contact"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Url(groups={"contact"})
     */
    private $www;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"contact"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $cellPhone;



    //--------------------------INVOICE DATA ------------------------

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"invoice"})
     */
    private $companyTitleInvoice;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"invoice"})
     */
    private $nipInvoice;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"invoice"})
     */
    private $streetInvoice;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"invoice"})
     */
    private $cityInvoice;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"invoice"})
     */
    private $zipInvoice;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Country(groups={"invoice"})
     */
    private $countryInvoice;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"invoice"})
     * @Assert\Email(groups={"invoice"})
     */
    private $emailInvoice;

    //------------------MAP---------------------------------------------------------------------------------------------

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"map"})
     */
    private $lat;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"map"})
     */
    private $lng;



    //-------------------------------------------------------------------------------------------------------------------
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @Assert\Valid()
     */
    protected $translations;



    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function getTitle() {
        return $this->translate()->getTitle();
    }


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
     * Set city
     *
     * @param string $city
     *
     * @return RsConfig
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
     * Set street
     *
     * @param string $street
     *
     * @return RsConfig
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set zip
     *
     * @param string $zip
     *
     * @return RsConfig
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
     * Set country
     *
     * @param string $country
     *
     * @return RsConfig
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return RsConfig
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
     * Set www
     *
     * @param string $www
     *
     * @return RsConfig
     */
    public function setWww($www)
    {
        $this->www = $www;

        return $this;
    }

    /**
     * Get www
     *
     * @return string
     */
    public function getWww()
    {
        return $this->www;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return RsConfig
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
     * Set cellPhone
     *
     * @param string $cellPhone
     *
     * @return RsConfig
     */
    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    /**
     * Get cellPhone
     *
     * @return string
     */
    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    /**
     * Set companyTitleInvoice
     *
     * @param string $companyTitleInvoice
     *
     * @return RsConfig
     */
    public function setCompanyTitleInvoice($companyTitleInvoice)
    {
        $this->companyTitleInvoice = $companyTitleInvoice;

        return $this;
    }

    /**
     * Get companyTitleInvoice
     *
     * @return string
     */
    public function getCompanyTitleInvoice()
    {
        return $this->companyTitleInvoice;
    }

    /**
     * Set nipInvoice
     *
     * @param string $nipInvoice
     *
     * @return RsConfig
     */
    public function setNipInvoice($nipInvoice)
    {
        $this->nipInvoice = $nipInvoice;

        return $this;
    }

    /**
     * Get nipInvoice
     *
     * @return string
     */
    public function getNipInvoice()
    {
        return $this->nipInvoice;
    }

    /**
     * Set streetInvoice
     *
     * @param string $streetInvoice
     *
     * @return RsConfig
     */
    public function setStreetInvoice($streetInvoice)
    {
        $this->streetInvoice = $streetInvoice;

        return $this;
    }

    /**
     * Get streetInvoice
     *
     * @return string
     */
    public function getStreetInvoice()
    {
        return $this->streetInvoice;
    }

    /**
     * Set cityInvoice
     *
     * @param string $cityInvoice
     *
     * @return RsConfig
     */
    public function setCityInvoice($cityInvoice)
    {
        $this->cityInvoice = $cityInvoice;

        return $this;
    }

    /**
     * Get cityInvoice
     *
     * @return string
     */
    public function getCityInvoice()
    {
        return $this->cityInvoice;
    }

    /**
     * Set zipInvoice
     *
     * @param string $zipInvoice
     *
     * @return RsConfig
     */
    public function setZipInvoice($zipInvoice)
    {
        $this->zipInvoice = $zipInvoice;

        return $this;
    }

    /**
     * Get zipInvoice
     *
     * @return string
     */
    public function getZipInvoice()
    {
        return $this->zipInvoice;
    }

    /**
     * Set countryInvoice
     *
     * @param string $countryInvoice
     *
     * @return RsConfig
     */
    public function setCountryInvoice($countryInvoice)
    {
        $this->countryInvoice = $countryInvoice;

        return $this;
    }

    /**
     * Get countryInvoice
     *
     * @return string
     */
    public function getCountryInvoice()
    {
        return $this->countryInvoice;
    }

    /**
     * Set emailInvoice
     *
     * @param string $emailInvoice
     *
     * @return RsConfig
     */
    public function setEmailInvoice($emailInvoice)
    {
        $this->emailInvoice = $emailInvoice;

        return $this;
    }

    /**
     * Get emailInvoice
     *
     * @return string
     */
    public function getEmailInvoice()
    {
        return $this->emailInvoice;
    }

    /**
     * Set lat
     *
     * @param string $lat
     *
     * @return RsConfig
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     *
     * @return RsConfig
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return RsConfig
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
}
