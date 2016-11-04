<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="client_documents")
 * @Vich\Uploadable
 */
class Document
{
    const TYPE_INN = 0;
    const TYPE_MILITARY_ID = 1;
    const TYPE_DRIVER_LICENCE = 2;
    const TYPE_SNILS = 3;
    const TYPE_INTERNATIONAL_PASSPORT = 4;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\Column(type="string")
     */
    private $image;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $comments;

    /**
     *  @Vich\UploadableField(mapping="documents_images", fileNameProperty="image")
     */
    private $imageFile;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="ClientBundle\Entity\Person", inversedBy="documents")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    private $client;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Document
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     * @return Document
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Document
     */
    public function setImage($image)
    {
        $this->image = $image;
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
     * @return Person
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Person $client
     * @return Document
     */
    public function setClient(Person $client)
    {
        $this->client = $client;
        return $this;
    }

    public static function getTypes()
    {
        return [
            self::TYPE_INN => 'ИНН',
            self::TYPE_MILITARY_ID => 'Военный билет',
            self::TYPE_DRIVER_LICENCE => 'Водительское удостоверение',
            self::TYPE_SNILS => 'СНИЛС',
            self::TYPE_INTERNATIONAL_PASSPORT => 'Загранпаспорт',
        ];
    }

}
