<?php

namespace KidzyBundle\Controller;

define('HUB_URL', 'http://localhost:3000/.well-known/mercure');
define('JWT', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtZXJjdXJlIjp7InB1Ymxpc2giOlsiKiJdfX0.CpZcJeRbvGNb9DPgRmnCuwinrypLk7UWdppPr-g4iHc');
use Doctrine\ORM\Query;
use http\Client\Response;
use KidzyBundle\Entity\Facture;
use KidzyBundle\Entity\Pack;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\Jwt\StaticJwtProvider;

/**
 * Pack controller.
 *
 */
class PackController extends Controller
{
    /**
     * Lists all pack entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $packs = $em->getRepository('KidzyBundle:Pack')->findAll();

        return $this->render('@Kidzy/pack/index.html.twig', array(
            'packs' => $packs
        ));
    }

    /**
     * Creates a new pack entity.
     *
     */
    public function newAction(Request $request )
    {
        $pack = new Pack();
        $form = $this->createForm('KidzyBundle\Form\PackType', $pack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pack);
            $em->flush();


            return $this->redirectToRoute('pack_show', array('idPack' => $pack->getIdpack()));
        }

        return $this->render('@Kidzy/pack/new.html.twig', array(
            'pack' => $pack,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pack entity.
     *
     */
    public function showAction(Pack $pack)
    {
        $deleteForm = $this->createDeleteForm($pack);

        return $this->render('@Kidzy/pack/show.html.twig', array(
            'pack' => $pack,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pack entity.
     *
     */
    public function editAction(Request $request, Pack $pack)
    {
        $deleteForm = $this->createDeleteForm($pack);
        $editForm = $this->createForm('KidzyBundle\Form\PackType', $pack);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pack_edit', array('idPack' => $pack->getIdpack()));
        }

        return $this->render('@Kidzy/pack/edit.html.twig', array(
            'pack' => $pack,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pack entity.
     *
     */
    public function deleteAction(Request $request, Pack $pack)
    {
        $form = $this->createDeleteForm($pack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pack);
            $em->flush();
        }

        return $this->redirectToRoute('pack_index');
    }

    /**
     * Creates a form to delete a pack entity.
     *
     * @param Pack $pack The pack entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pack $pack)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pack_delete', array('idPack' => $pack->getIdpack())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function pricingAction()
    {
        $em = $this->getDoctrine()->getManager();
        $packs = $em->getRepository('KidzyBundle:Pack')->findAll();
        $frais = $em->getRepository('KidzyBundle:Frais')->findAll();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        return $this->render('@Kidzy/pack/pricing.html.twig' , array('packs' => $packs ,'parent' => $user,'frais'=>$frais));
    }
    public function buyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('idPack');
        $idEnfant = $request->get('enfant');
        $pack = $em->getRepository('KidzyBundle:Pack')->find($id);
        $enfant = $em->getRepository('KidzyBundle:Enfant')->find($idEnfant);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $idParent = $user->getId();

        \Stripe\Stripe::setApiKey('sk_test_8TNB5HaJ0H5lWP5qMso3OWDI00syLPhFY3');

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'name' => $pack->getNomPack(),
                'description' => $pack->getDescriptionPack(),
                'images' => ['https://image.freepik.com/free-vector/e-mail-news-subscription-promotion-flat-vector-illustration-design-newsletter-icon-flat_1200-330.jpg'],
                'amount' => $pack->getPrixPack() * 100,
                'currency' => 'usd',
                'quantity' => 1,
            ]],
            'success_url' => 'http://localhost/webkidzy/web/app_dev.php/kidzy/packs/success/'.$id.'/'.$idEnfant.'/{CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://localhost/webkidzy/web/app_dev.php/kidzy/packs/'.$id.'/buy?enfant='.$idEnfant,
        ]);


        return $this->render('@Kidzy/pack/confirm.html.twig' , array('pack' => $pack , 'CHECKOUT_SESSION_ID'=>$session->id ,'enfant' =>$enfant ));
    }

    public function successAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('idPack');
        $idEnfant = $request->get('idEnfant');
        $pack = $em->getRepository('KidzyBundle:Pack')->find($id);
        $enfant = $em->getRepository('KidzyBundle:Enfant')->find($idEnfant);
        $idParent = $request->get('idParent');
        $userManager = $this->container->get('fos_user.user_manager');
        //$parent = $userManager->findUserBy(array('id'=>$idParent));
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $facture = new Facture();

        $facture->setDateFacture(new \DateTime());
        $facture->setPack($pack);
        $facture->setPaye(true);
        $facture->setTotal($pack->getPrixPack());
        $facture->setIdParent($user);
        $facture->setIdEnf($enfant);
        $facture->setStatus(0);
        $em->persist($facture);
        $em->flush();
        $publisher = new Publisher(HUB_URL, new StaticJwtProvider(JWT));
        $publisher(new Update('ping', '$facture'));


        return $this->render('@Kidzy/pack/success.html.twig' , array('user' => $user , 'pack' => $pack , 'enfant' => $enfant ,'facture' => $facture));
    }

    public function factureAction()
    {
        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository('KidzyBundle:Facture')->findAll();

        return $this->render('@Kidzy/pack/facture.html.twig', array(
            'factures' => $factures,
        ));
    }

    public function printAction(Request $request)
    {
        $idParent = $request->get('idParent');
        $idEnfant = $request->get('idEnfant');
        $idPack = $request->get('idPack');
        $idFacture = $request->get('idFacture');
        $em = $this->getDoctrine()->getManager();
        $pack = $em->getRepository('KidzyBundle:Pack')->find($idPack);
        $enfant = $em->getRepository('KidzyBundle:Enfant')->find($idEnfant);
        $facture = $em->getRepository('KidzyBundle:Facture')->find($idFacture);
        $userManager = $this->container->get('fos_user.user_manager');
        $parent = $userManager->findUserBy(array('id'=>$idParent));


        $html = $this->renderView('@Kidzy/pack/print.html.twig', array(
            'enfant'  => $enfant,
            'parent' => $parent,
            'pack' => $pack,
            'facture' => $facture
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'facture.pdf'
        );
    }
}
