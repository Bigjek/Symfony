<?php

namespace ClientBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "person" = "Person",
 * })
 * @ORM\Table(name="clients")
 */
class Client
{

    const APPROVE_GROUP = 3;
    const NEED_APPROVE_TO_ENABLE = 3;

    const STATUS_WAIT_APPROVE = 0;
    const STATUS_FULL_APPROVED = 1;
    const STATUS_PART_APPROVE = 2;
    const STATUS_DECLINE = 3;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $contractNumber;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $contractAcceptDate;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $status;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="ClientBundle\Entity\Referrer", inversedBy="clients")
     * @ORM\JoinTable(name="clients_referrers")
     */
    private $referrers;

    /**
     * @ORM\Column(type="array")
     */
    private $friends;

    /**
     * @var ArrayCollection|User[]
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinTable(name="client_users_approved",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="client_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $approvedBy;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", inversedBy="client")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public static function getStatusList()
    {
        return [
            self::STATUS_WAIT_APPROVE => 'Ожидает',
            self::STATUS_FULL_APPROVED => 'Принят',
            self::STATUS_PART_APPROVE => 'Частично',
            self::STATUS_DECLINE => 'Отклонен'
        ];
    }

    public function getStatusesForChange()
    {
        $currentStatus = $this->getStatus();
        return array_filter(self::getStatusList(), function($key) use ($currentStatus){
            return $key != $currentStatus;
        }, ARRAY_FILTER_USE_KEY);
    }


    public function __construct()
    {
        $this->referrers = new ArrayCollection();
        $this->approvedBy = new ArrayCollection();
        $this->status = self::STATUS_WAIT_APPROVE;
        $this->friends = [];
    }

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
    public function getContractNumber()
    {
        return $this->contractNumber;
    }

    /**
     * @param mixed $contractNumber
     * @return Client
     */
    public function setContractNumber($contractNumber)
    {
        $this->contractNumber = $contractNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContractAcceptDate()
    {
        return $this->contractAcceptDate;
    }

    /**
     * @param mixed $contractAcceptDate
     * @return Client
     */
    public function setContractAcceptDate($contractAcceptDate)
    {
        $this->contractAcceptDate = $contractAcceptDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Client
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Client
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return array
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * @param array $friends
     * @return Client
     */
    public function setFriends($friends)
    {
        $this->friends = $friends;
        return $this;
    }

    /**
     * @return ArrayCollection|Referrer[]
     */
    public function getReferrers()
    {
        return $this->referrers;
    }

    /**
     * @param Referrer $referrer
     * @return Client
     */
    public function addReferrer(Referrer $referrer)
    {
        $referrer->addClient($this);
        $this->referrers->add($referrer);
        return $this;
    }

    /**
     * @param Referrer $referrer
     * @return Client
     */
    public function removeReferrer(Referrer $referrer)
    {
        $referrer->removeClient($this);
        $this->referrers->removeElement($referrer);
        return $this;
    }

    public function hasApprovedBy(User $user)
    {
        return $this->approvedBy->contains($user);
    }

    public function getNeedApprove()
    {
        return self::NEED_APPROVE_TO_ENABLE;
    }

    public function getApproveCount()
    {
        return $this->approvedBy->count();
    }

    public function getApprovedBy()
    {
        return $this->approvedBy;
    }

    public function approve(User $user)
    {
        $this->approvedBy->add($user);
        return $this;
    }

    public function disallowBy(User $user)
    {
        $this->approvedBy->removeElement($user);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Client
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

}
