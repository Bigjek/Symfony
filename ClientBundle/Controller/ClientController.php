<?php

namespace ClientBundle\Controller;

use ClientBundle\ClientEvents;
use ClientBundle\Entity\Person;
use ClientBundle\Event\ClientEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends Controller
{
    /**
     * @Route("/new/person", name="new_person_client")
     */
    public function newPersonAction(Request $request)
    {
        $person = new Person();
        $form = $this->createForm("ClientBundle\Form\PersonType", $person, ['action' => $this->generateUrl('new_person_client')]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
            $event = new ClientEvent($person);
            $this->dispatch(ClientEvents::CLIENT_CREATE, $event);
            return $this->render('Client/success.html.twig', array('form'=>$form->createView()));
        }
        return $this->render('Client/form.html.twig', array('form'=>$form->createView()));
    }

    private function dispatch($eventName, Event $event)
    {
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch($eventName, $event);
    }
}
