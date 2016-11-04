<?php

namespace ClientBundle\Controller\Admin;

use ClientBundle\Entity\Action\CommentAction;
use ClientBundle\Entity\Action\StatusAction;
use ClientBundle\Entity\Client;
use ClientBundle\Form\Action\StatusActionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Form\Action\CommentActionType;

/**
 * Class ClientController
 * @package ClientBundle\Controller\Admin
 * @Route("/client")
 */
class ClientController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new", name="admin_client_list_new")
     */
    public function newListAction()
    {
        $entities = $this->getDoctrine()->getRepository('ClientBundle:Person')->findBy([
            'status'=> [
                Client::STATUS_WAIT_APPROVE,
            ]
        ]);
        return $this->render('ClientBundle:Admin/Client:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/processed", name="admin_client_list_processed")
     */
    public function processedListAction()
    {
        $entities = $this->getDoctrine()->getRepository('ClientBundle:Person')->findBy([
            'status'=> [
                Client::STATUS_FULL_APPROVED,
                Client::STATUS_PART_APPROVE,
                Client::STATUS_DECLINE,
            ]
        ]);
        return $this->render('ClientBundle:Admin/Client:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/comment", name="admin_client_add_comment")
     */
    public function addCommentAction(Request $request, $id)
    {
        $client = $this->getDoctrine()->getRepository('ClientBundle:Person')->find($id);
        $user = $this->getUser();
        $commentAction = new CommentAction();
        $commentAction->setClient($client);
        $commentAction->setUser($user);

        $form = $this->createForm(CommentActionType::class, $commentAction, ['action' => $this->generateUrl('admin_client_add_comment', ['id'=>$id ])]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentAction);
            $em->flush();
            return new RedirectResponse($this->generateUrl('admin_client_list_new'));
        }
        return $this->render('ClientBundle:Admin/Client/Form:commentForm.html.twig', array('form'=>$form->createView()));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/change-status", name="admin_client_change_status")
     */
    public function changeStatusAction(Request $request, $id)
    {
        $client = $this->getDoctrine()->getRepository('ClientBundle:Person')->find($id);
        $user = $this->getUser();
        $statusAction = new StatusAction();
        $statusAction->setClient($client);
        $statusAction->setUser($user);


        $form = $this->createForm(StatusActionType::class, $statusAction, ['action' => $this->generateUrl('admin_client_change_status', ['id'=>$id ])]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $statusAction->setOldStatus($client->getStatus());
            $client->setStatus($statusAction->getNewStatus());
            $em->persist($statusAction);
            $em->persist($client);
            $em->flush();
            return new RedirectResponse($this->generateUrl('admin_client_list_new'));
        }
        return $this->render('ClientBundle:Admin/Client/Form:statusForm.html.twig', array('form'=>$form->createView()));
    }

}
