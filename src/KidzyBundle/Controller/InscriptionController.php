<?php

namespace KidzyBundle\Controller;

use KidzyBundle\Entity\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Inscription controller.
 *
 */
class InscriptionController extends Controller
{
    /**
     * Lists all Inscription entities.
     *
     */
    public function listeAction(Request $request ,$idClub)
    {        $idClub = $request->get('idClub');
        $repository = $this->getDoctrine()->getManager()->getRepository(Inscription::class);
        $listenfants=$repository->myfinfDomaine($idClub);

        return $this->render('@Kidzy/inscription/listeAdmin.html.twig', array('liste' => $listenfants,'idClub'=>$idClub));

    }
    public function showAction( Request $request)
    {
        $idInscrit = $request->get('idInscrit');
        $idClub = $request->get('idClub');
        $idEnfant = $request->get('idEnfant');

        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository('KidzyBundle:Club')->find($idClub);
        $enfant = $em->getRepository('KidzyBundle:Enfant')->find($idEnfant);
        $Inscrit = $em->getRepository('KidzyBundle:Inscription')->find($idInscrit);

        $deleteForm = $this->createDeleteForm($Inscrit,$idClub);


        return $this->render('@Kidzy/inscription/show.html.twig', array(
            'club' => $club,
            'enfant' => $enfant,
            'inscription' => $Inscrit,
            'delete_form' => $deleteForm->createView()


        ));
    }

    private function createDeleteForm(Inscription $Inscription,$idClub)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inscription_delete', array('idInscrit' => $Inscription->getIdInscrit(),'idClub' =>$idClub)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function deleteAction(Request $request, Inscription $club, $idClub)
    {
        $form = $this->createDeleteForm( $club,$idClub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove( $club);
            $em->flush();
        } return $this->redirectToRoute('inscription_enfantAdmin',array('idClub' => $idClub));
    }

    public function newAction(Request $request)

    {
        $idClub = $request->get('idClub');
        $em = $this->getDoctrine()->getManager();

        $club = $em->getRepository('KidzyBundle:Club')->find($idClub);
        $repository = $this->getDoctrine()->getManager()->getRepository(Inscription::class);
        $listenfants=$repository->myfinfDomaine($idClub);


        $inscription = new Inscription();
        $form = $this->createForm('KidzyBundle\Form\InscriptionType', $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getManager()->getRepository(Inscription::class);
            $existe=$repository->myfinfInsc($inscription->getIdEnfant(),$inscription->getIdClub());
            if ($existe) {
                $this->addFlash('message', 'Enfant inscrit déja');

            }else {

                $today = new \DateTime('now');
                $inscription->setDateInscrit($today);
                $em->persist($inscription);
                $em->flush();
                $this->addFlash('message', 'Enfant inscrit avec succés');
            }
         return $this->redirectToRoute('inscription_enfantAdmin',array('idClub' => $club->getIdClub()));
        }

        return $this->render('@Kidzy/inscription/new.html.twig', array(
            'inscription' => $inscription,
            'liste' => $listenfants,
            'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, Inscription $Inscription)
    {
        $idClub = $request->get('idClub');
        $idEnfant = $request->get('idEnfant');
        $editForm = $this->createForm('KidzyBundle\Form\DescriptionType', $Inscription);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inscription_show', array('idInscrit' => $Inscription->getIdInscrit(),'idEnfant' => $idEnfant,'idClub' => $idClub));
        }

        return $this->render('@Kidzy/inscription/edit.html.twig', array(
            'inscription' => $Inscription,
            'idClub' => $idClub,
            'enfant' => $idEnfant,
            'edit_form' => $editForm->createView(),

        ));
    }
   }