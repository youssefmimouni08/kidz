<?php

namespace KidzyBundle\Controller;

use KidzyBundle\Entity\Reclamations;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use KidzyBundle\Form\ReclamationsType;

class ReclamationsController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rec = $em->getRepository('KidzyBundle:Reclamations')->findAll();

        return $this->render('@Kidzy/reclamations/index.html.twig', array(
            'rec' => $rec,
        ));
    }





    public function showAction(Reclamations $rec)
    {
        $deleteForm = $this->createDeleteForm($rec);

        return $this->render('@Kidzy/reclamations/show.html.twig', array(
            'rec' => $rec,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    public function deleteAction(Request $request, Reclamations $rec)
    {
        $form = $this->createDeleteForm($rec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rec);
            $em->flush();
        }

        return $this->redirectToRoute('reclamations_index');
    }


    private function createDeleteForm(Reclamations $rec)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reclamations_delete', array('idRec' => $rec->getIdRec())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function editAction(Request $request, Reclamations $rec)
    {
        $deleteForm = $this->createDeleteForm($rec);
        $editForm = $this->createForm('KidzyBundle\Form\ReclamationsType', $rec);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $rec->setEtatRec("oui");
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamations_edit', array('idRec' => $rec->getIdRec()));
        }

        return $this->render('@Kidzy/reclamations/edit.html.twig', array(
            'frai' => $rec,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


}

