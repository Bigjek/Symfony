# Symfony
Простановка связей Один ко многим


В первом Entity создаем переменную $bookings, добавляем функцию __construct(), создаем ArrayCollection() и добавляем гетеры и сетеры
   
     /**
     * @ORM\OneToMany(
     *     targetEntity="ClientBundle\Entity\Booking",
     *     mappedBy="client",
     *     cascade={"all"},
     *     orphanRemoval=true
     *     )
     */
     
    private $bookings;
    
    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->addBooking(new Booking());
        parent::__construct();
    }
     /**
     * @return mixed
     */
    public function getBookings()
    {
        return $this->bookings;
    }

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
