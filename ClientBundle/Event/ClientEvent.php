<?php

namespace ClientBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use ClientBundle\Entity\Client;

class ClientEvent extends Event
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

}