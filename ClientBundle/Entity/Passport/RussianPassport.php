<?php

namespace ClientBundle\Entity\Passport;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="client_passport_russian")
 * @Vich\Uploadable
 */
class RussianPassport extends Passport
{
    /**
     * @ORM\Column(type="string")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string")
     */
    private $patronymic;
    

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;


    /**
     * @ORM\Column(type="string")
     */
    private $passportSeries;

    /**
     * @ORM\Column(type="string")
     */
    private $passportIssuedBy;

    /**
     * @ORM\Column(type="date")
     */
    private $passportIssuedDate;

    /**
     * @ORM\Column(type="string")
     */
    private $registrationAddress;

    /**
     * @var string
     * @ORM\Column(name="main_image", type="string")
     */
    private $mainImage;
    /**
     * @var File
     * @Vich\UploadableField(mapping="passports_images", fileNameProperty="mainImage")
     */
    private $mainImageFile;

    /**
     * @var string
     * @ORM\Column(name="address_image", type="string")
     */
    private $addressImage;
    /**
     * @var File
     * @Vich\UploadableField(mapping="passports_images", fileNameProperty="addressImage")
     */
    private $addressImageFile;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return RussianPassport
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return RussianPassport
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * @param string $patronymic
     * @return RussianPassport
     */
    public function setPatronymic($patronymic)
    {
        $this->patronymic = $patronymic;
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     * @return RussianPassport
     */
    public function setBirthDate(\DateTime $birthDate = null)
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassportSeries()
    {
        return $this->passportSeries;
    }

    /**
     * @param mixed $passportSeries
     * @return RussianPassport
     */
    public function setPassportSeries($passportSeries)
    {
        $this->passportSeries = $passportSeries;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassportIssuedBy()
    {
        return $this->passportIssuedBy;
    }

    /**
     * @param string $passportIssuedBy
     * @return RussianPassport
     */
    public function setPassportIssuedBy($passportIssuedBy)
    {
        $this->passportIssuedBy = $passportIssuedBy;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPassportIssuedDate()
    {
        return $this->passportIssuedDate;
    }

    /**
     * @param \DateTime $passportIssuedDate
     * @return RussianPassport
     */
    public function setPassportIssuedDate(\DateTime $passportIssuedDate = null)
    {
        $this->passportIssuedDate = $passportIssuedDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegistrationAddress()
    {
        return $this->registrationAddress;
    }

    /**
     * @param string $registrationAddress
     * @return RussianPassport
     */
    public function setRegistrationAddress($registrationAddress)
    {
        $this->registrationAddress = $registrationAddress;
        return $this;
    }

    public function getName()
    {
        return $this->lastName.' '.$this->firstName;
    }

    /**
     * @return string
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @param string $mainImage
     * @return RussianPassport
     */
    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddressImage()
    {
        return $this->addressImage;
    }

    /**
     * @param string $addressImage
     * @return RussianPassport
     */
    public function setAddressImage($addressImage)
    {
        $this->addressImage = $addressImage;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return RussianPassport
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @param File $mainImageFile
     * @return RussianPassport
     */
    public function setMainImageFile(File $mainImageFile)
    {
        $this->mainImageFile = $mainImageFile;

        if ($mainImageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getMainImageFile()
    {
        return $this->mainImageFile;
    }

    /**
     * @return File
     */
    public function getAddressImageFile()
    {
        return $this->addressImageFile;
    }
    /**
     * @param File $addressImageFile
     * @return RussianPassport
     */
    public function setAddressImageFile(File $addressImageFile)
    {
        $this->addressImageFile = $addressImageFile;

        if ($addressImageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

}
