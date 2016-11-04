<?php

namespace ClientBundle\Entity;

use ClientBundle\Entity\Passport\PassportInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



/**
 * @ORM\Entity
 * @ORM\Table(name="clients_person")
 * @Vich\Uploadable
 */
class Person extends Client
{

    const  CONTRACT_PREFIX = 'П';

    const SOCIAL_TYPE_VK = 'vk';
    const SOCIAL_TYPE_FB = 'fb';
    const SOCIAL_TYPE_INSTA = 'insta';
    const SOCIAL_TYPE_HH = 'hh';

    const EMPLOY_TYPE_WORK = 'work';
    const EMPLOY_TYPE_STUDY = 'study';
    const EMPLOY_TYPE_STUDYWORK = 'studywork';

    /**
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $homePhone;

    /**
     * @ORM\Column(type="string")
     */
    private $mobilePhone;

    /**
     * @ORM\Column(type="array")
     */
    private $socialProfiles;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $url;

    /**
     * @var PassportInterface
     * @ORM\OneToOne(targetEntity="ClientBundle\Entity\Passport\Passport", cascade={"all"})
     * @ORM\JoinColumn(name="shipping_id", referencedColumnName="id")
     */
    private $passport;

    /**
     * @ORM\OneToMany(
     *     targetEntity="ClientBundle\Entity\Document",
     *     mappedBy="client",
     *     cascade={"all"},
     *     orphanRemoval=true
     *     )
     */
    private $documents;

    /**
     * @ORM\OneToMany(
     *     targetEntity="ClientBundle\Entity\Booking",
     *     mappedBy="client",
     *     cascade={"all"},
     *     orphanRemoval=true
     *     )
     */
    private $bookings;

    /**
     * @ORM\Column(type="string")
     */
    private $avatar;

    /**
     *  @Vich\UploadableField(mapping="client_avatar", fileNameProperty="avatar")
     */
    private $imageFile;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $employmentType;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $employmentDetails;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $employmentNewType;

    /**
     * @var array
     * @ORM\Column(type="string", nullable=true)
     */
    private $employmentNewDetails;


    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->addDocument(new Document());
        $this->addDocument(new Document());
        $this->addBooking(new Booking());
        $this->socialProfiles = [[]];
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Person
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return Person
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getHomePhone()
    {
        return $this->homePhone;
    }

    /**
     * @param string $homePhone
     * @return Person
     */
    public function setHomePhone($homePhone)
    {
        $this->homePhone = $homePhone;
        return $this;
    }

    /**
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @param string $mobilePhone
     * @return Person
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
        return $this;
    }

    /**
     * @return array
     */
    public function getSocialProfiles()
    {
        return $this->socialProfiles;
    }

    /**
     * @param array $socialProfiles
     * @return Person
     */
    public function setSocialProfiles($socialProfiles)
    {
        $this->socialProfiles = $socialProfiles;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return PassportInterface
     */
    public function getPassport()
    {
        return $this->passport;
    }

    /**
     * @param PassportInterface $passport
     * @return Person
     */
    public function setPassport(PassportInterface $passport)
    {
        $this->passport = $passport;
        return $this;
    }

    public function getName()
    {
        return $this->passport->getName();
    }

    /**
     * @return mixed
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    public function addDocument(Document $document)
    {
        $document->setClient($this);
        $this->documents->add($document);
        return $this;
    }

    public function removeDocument(Document $document)
    {
        $this->documents->removeElement($document);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBookings()
    {
        return $this->bookings;
    }

    // /**
    //  * @param mixed $bookings
    //  * @return Person
    //  */
    // public function setBookings($bookings)
    // {
    //     $this->bookings = $bookings;
    //     return $this;
    // }

    public function addBooking($booking)
    {
        $booking->setClient($this);
        $this->bookings->add($booking);
        return $this;
    }

    public function removeBooking($booking)
    {
        $this->bookings->removeElement($booking);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     * @return Person
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     * @return Document
     */
    public function setImageFile(File $imageFile)
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }

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
     * @return Document
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmploymentType()
    {
        return $this->employmentType;
    }

    /**
     * @param string $employmentType
     * @return Person
     */
    public function setEmploymentType($employmentType)
    {
        $this->employmentType = $employmentType;
        return $this;
    }

    /**
     * @return array
     */
    public function getEmploymentDetails()
    {
        return $this->employmentDetails;
    }

    /**
     * @param array $employmentDetails
     * @return Person
     */
    public function setEmploymentDetails($employmentDetails)
    {
        $this->employmentDetails = $employmentDetails;
        return $this;
    }


    /**
     * @return string
     */
    public function getEmploymentNewType()
    {
        return $this->employmentNewType;
    }

    /**
     * @param string $employmentNewType
     * @return Person
     */
    public function setEmploymentNewType($employmentNewType)
    {
        $this->employmentNewType = $employmentNewType;
        return $this;
    }

    /**
     * @return array
     */
    public function getEmploymentNewDetails()
    {
        return $this->employmentNewDetails;
    }

    /**
     * @param array $employmentNewDetails
     * @return Person
     */
    public function setEmploymentNewDetails($employmentNewDetails)
    {
        $this->employmentNewDetails = $employmentNewDetails;
        return $this;
    }






    public static function getSocialProfileTypes()
    {
        return [
            self::SOCIAL_TYPE_VK => 'ВКонтакте',
            self::SOCIAL_TYPE_FB => 'FaceBook',
            self::SOCIAL_TYPE_INSTA => 'Instagram',
            self::SOCIAL_TYPE_HH => 'HeadHunter',
        ];
    }

    public static function getEmployTypes()
    {
        return [
            self::EMPLOY_TYPE_STUDYWORK => 'Работаю и учусь',
            self::EMPLOY_TYPE_WORK => 'Работаю',
            self::EMPLOY_TYPE_STUDY => 'Учусь'
        ];
    }

}