<?php

namespace KidzyBundle\Controller;

use KidzyBundle\Entity\Enfant;
use KidzyBundle\Entity\Classe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EnfantController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $enfants = $em->getRepository('KidzyBundle:Enfant')->findAll();

        return $this->render('@Kidzy/enfant/index.html.twig', array(
            'enfants' => $enfants,
        ));
    }

    public function showAction(Enfant $enfant)
    {
        $deleteForm = $this->createDeleteForm($enfant);

        return $this->render('@Kidzy/enfant/show.html.twig', array(
            'enfant' => $enfant,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a enfant entity.
     *
     * @param Enfant $enfant The enfant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */

    private function createDeleteForm(Enfant $enfant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('enfant_delete', array('idEnfant' => $enfant->getIdEnfant())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Deletes a enfant entity.
     *
     */
    public function deleteAction(Request $request, Enfant $enfant)
    {
        $form = $this->createDeleteForm($enfant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enfant);
            $em->flush();
        }

        return $this->redirectToRoute('enfant_index');
    }

    public function editAction(Request $request, Enfant $enfant)
    {
        $deleteForm = $this->createDeleteForm($enfant);
        $editForm = $this->createForm('KidzyBundle\Form\EnfantType', $enfant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('enfant_edit', array('idEnfant' =>$enfant->getIdEnfant()));
        }

        return $this->render('@Kidzy/enfant/edit.html.twig', array(
            'enfant' =>$enfant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a new garde entity.
     *
     */
    public function newAction(Request $request)
    {
        $enfant = new Enfant();
        $form = $this->createForm('KidzyBundle\Form\EnfantType', $enfant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $today = new \DateTime('now');
            $enfant->setUpdatedAt($today);
            $em->persist($enfant);
            $em->flush();

            return $this->redirectToRoute('enfant_show', array('idEnfant' => $enfant->getIdEnfant()));
        }

        return $this->render('@Kidzy/enfant/new.html.twig', array(
            'enfant' => $enfant,
            'form' => $form->createView(),
        ));
    }

    public function enfantAction()
    {
        $em = $this->getDoctrine()->getManager();
        $enfants = $em->getRepository('KidzyBundle:Enfant')->findAll();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        return $this->render('@Kidzy/enfant/enfant.html.twig' , array('enfants' => $enfants ,'parent' => $user ));
    }

    public function addAction(Request $request)
    {
        $enfant = new Enfant();

        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository('KidzyBundle:Classe')->findAll();
        $user = $this->getUser();
        if ($request->isMethod("POST")) {
            $enfant->setImageEnfant($request->get('imageFile'));
            $enfant->setNomEnfant($request->get('nomEnfant'));
            $enfant->setPrenomEnfant($request->get('prenomEnfant'));
           $enfant->setIdClasse($classe);
            $enfant->setDatenEnfant($request->get('datenEnfant'));
            $enfant->setIdParent($user);

            $em->persist($enfant);
            $em->flush();

            return $this->redirectToRoute('enfant');
        }

        return $this->render('@Kidzy/enfant/add.html.twig', array('classe' => $classe   ));
    }



    public function supprimerAction($idEnfant)
    {

        $em=$this->getDoctrine()->getManager();
        $enfant =$em ->getRepository(Enfant::class) ->find($idEnfant);
        $em->remove($enfant);
        $em->flush();
        return $this->redirectToRoute("enfant" );
    }

    public function modifierAction( Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $enfant =$em ->getRepository(Enfant::class) ->find($id);
        $classe = $em->getRepository('KidzyBundle:Classe')->findAll();
        if ($request->isMethod('POST')) {
            $enfant->setImageEnfant($request->get('imageFile'));
            $enfant->setNomEnfant($request->get('nomEnfant'));
            $enfant->setPrenomEnfant($request->get('prenomEnfant'));
           // $enfant->setIdClasse($request->get('idClasse'));
            $enfant->setDatenEnfant($request->get('datenEnfant'));

            $em->flush();
            return $this->redirectToRoute('enfant');
        }
        return $this->render('@Kidzy/enfant/modifier.html.twig',array('enfant'=>$enfant , 'classe' => $classe));

    }


}
