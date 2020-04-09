<?php

namespace KidzyBundle\Controller;

use KidzyBundle\Entity\Club;
use KidzyBundle\Entity\Event;
use KidzyBundle\Entity\Inscription;
use KidzyBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Club controller.
 *
 */
class ClubController extends Controller
{
    /**
     * Lists all Club entities.
     *
     */
    public function showEventAction( $idClub)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getManager()->getRepository(Event::class);
        $event=$repository->myfinfEvent($idClub);
        $clubs = $em->getRepository('KidzyBundle:Club')->find($idClub);

        return $this->render('@Kidzy/club/EventFront.html.twig', array(
            'event' => $event,
            'club' => $clubs

        ));
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $club = $em->getRepository('KidzyBundle:Club')->findAll();

        return $this->render('@Kidzy/club/index.html.twig', array(
            'club' => $club,
        ));
    }
    public function indexClubAction()
    {
        $em = $this->getDoctrine()->getManager();

        $club = $em->getRepository('KidzyBundle:Club')->findAll();

        return $this->render('@Kidzy/club/AutreClubFront.html.twig', array(
            'club' => $club,
        ));
    }
    public function indexParentAction()
    {   $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $idParent = $user->getId();

        $repository = $this->getDoctrine()->getManager()->getRepository(Club::class);
        $listenfants=$repository->myfinfClub($idParent);


        return $this->render('@Kidzy/club/ClubFront.html.twig', array(
            'club' => $listenfants,
        ));
    }
    /**
     * Creates a new club entity.
     *
     */


public function newAction(Request $request)
    {
        $club = new Club();
        $form = $this->createForm('KidzyBundle\Form\ClubType', $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            $notifications=new Notification();
            $notifications->setTitle('nouveau Club')
                ->setDescription($club->getNomClub())
                ->setRoute('user')
                ->setParameters(array('id'=>$club->getIdClub()));
            $em->persist($notifications);
            $em->flush();
            $pusher = $this->get('mrad.pusher.notificaitons');
            $pusher->trigger($notifications);

            return $this->redirectToRoute('club_show', array('idClub' => $club->getIdClub()));
        }

        return $this->render('@Kidzy/club/new.html.twig', array(
            'club' => $club,
            'form' => $form->createView(),
        ));
    }
    public function showAction(Request $request,Club $club)
    {
        $deleteForm = $this->createDeleteForm($club);
        $repository = $this->getDoctrine()->getManager()->getRepository(Inscription::class);
        $idClub = $request->get('idClub');

        $nbrenfants=$repository->myfinfnbre($idClub);

        return $this->render('@Kidzy/club/show.html.twig', array(
            'club' => $club,
            'nbre' => $nbrenfants,
            'delete_form' => $deleteForm->createView()
        ));
    }

    public function deleteAction(Request $request, Club $club)
    {
        $form = $this->createDeleteForm( $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove( $club);
            $em->flush();

        }

        return $this->redirectToRoute('club');
    }
    private function createDeleteForm(Club $club)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('club_delete', array('idClub' => $club->getIdClub())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function editAction(Request $request, Club $club)
    {
        $Form = $this->createDeleteForm($club);
        $editForm = $this->createForm('KidzyBundle\Form\ClubType', $club);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Club modifié avec succés');

            return $this->redirectToRoute('club_edit', array('idClub' => $club->getIdClub()));
        }else {}

        return $this->render('@Kidzy/club/edit.html.twig', array(
            'club' => $club,
            'edit_form' => $editForm->createView(),
            'delete_form' => $Form->createView(),
        ));
    }
}
