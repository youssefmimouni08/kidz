<?php

namespace KidzyBundle\Controller;

use KidzyBundle\Entity\Garde;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GardeController extends Controller
{
    /**
     * Lists all garde entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $gardes = $em->getRepository('KidzyBundle:Garde')->findAll();

        return $this->render('@Kidzy/garde/index.html.twig', array(
            'gardes' => $gardes,
        ));
    }

    /**
     * Creates a new garde entity.
     *
     */
    public function newAction(Request $request)
    {
        $garde = new Garde();
        $form = $this->createForm('KidzyBundle\Form\GardeType', $garde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($garde);
            $em->flush();

            return $this->redirectToRoute('garde_show', array('idGarde' => $garde->getIdGarde()));
        }

        return $this->render('@Kidzy/garde/new.html.twig', array(
            'garde' => $garde,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a garde entity.
     *
     */
    public function showAction(Garde $garde)
    {
        $deleteForm = $this->createDeleteForm($garde);

        return $this->render('@Kidzy/garde/show.html.twig', array(
            'garde' => $garde,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing frai entity.
     *
     */
    public function editAction(Request $request, Garde $garde)
    {
        $deleteForm = $this->createDeleteForm($garde);
        $editForm = $this->createForm('KidzyBundle\Form\GardeType', $garde);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('garde_edit', array('idGarde' => $garde->getIdGarde()));
        }

        return $this->render('@Kidzy/garde/edit.html.twig', array(
            'garde' => $garde,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a garde entity.
     *
     */
    public function deleteAction(Request $request, Garde $garde)
    {
        $form = $this->createDeleteForm($garde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($garde);
            $em->flush();
        }

        return $this->redirectToRoute('garde_index');
    }

    /**
     * Creates a form to delete a garde entity.
     *
     * @param Garde $garde The garde entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Garde $garde)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('garde_delete', array('idGarde' => $garde->getIdGarde())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function listAction(Request $request, Garde $garde)
    {

        return $this->render('@Kidzy/garde/list.html.twig', array(
            'garde' => $garde,

        ));

    }


    public function gardeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $gardes = $em->getRepository('KidzyBundle:Garde')->findAll();

        return $this->render('@Kidzy/garde/garde.html.twig' , array('gardes' => $gardes  ));
    }
}
