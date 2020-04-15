<?php

namespace KidzyBundle\Controller;

use KidzyBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Event controller.
 *
 */
class EventController extends Controller
{
    /**
     * Lists all event entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('KidzyBundle:Event')->findAll();

        return $this->render('@Kidzy/event/index.html.twig', array(
            'event' => $event,
        ));
    }

    public function indexParentAction()
    {   $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $idParent = $user->getId();

        $repository = $this->getDoctrine()->getManager()->getRepository(Event::class);
        $listenfants=$repository->myfinfEvent($idParent);
        var_dump($idParent);
        var_dump($listenfants);
        die();

        return $this->render('@Kidzy/event/event.html.twig', array(
            'event' => $listenfants,
        ));
    }


    /**
     * Creates a new event entity.
     *
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('KidzyBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', array('idEvent' => $event->getIdevent()));
        }

        return $this->render('@Kidzy/event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a event entity.
     *
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('@Kidzy/event/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('KidzyBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_edit', array('idEvent' => $event->getIdevent()));
        }

        return $this->render('@Kidzy/event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('idEvent' => $event->getIdevent())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function eventAction(){
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('KidzyBundle:Event')->findAll();

        return $this->render('@Kidzy/event/event.html.twig', array(
            'event' => $event,
        ));
    }
}
