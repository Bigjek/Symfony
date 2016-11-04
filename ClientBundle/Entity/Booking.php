<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="client_bookings")
 */
class Booking
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="ClientBundle\Entity\Person", inversedBy="bookings")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $tovar;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @return Booking
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
     * @return Booking
     */
    public function setClient(Person $client)
    {
        $this->client = $client;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getTovar()
    {
        return $this->tovar;
    }

    /**
     * @param mixed $tovar
     * @return Booking
     */
    public function setTovar($tovar)
    {
        $this->tovar = $tovar;
        return $this;
    }

}
