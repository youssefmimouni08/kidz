<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    public function adminAction()
    {
        return $this->render('@User/Default/dashboard.html.twig');
    }
    public function maitresseAction()
    {
        return $this->render('@User/Default/maitresse_dashboard.html.twig');
    }

    public function notificationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $results = $qb->select('e')
            ->from('KidzyBundle:Facture', 'e')
            ->where('e.dateFacture >= :dateFacture')
            ->setParameter('dateFacture', new \DateTime('-48 hours'))
            ->getQuery()
            ->getResult();

        return $this->render('@User/Default/notifications.html.twig',['notif' => $results]);
    }
    public function accountInfo()
    {
        // allow any authenticated user - we don't care if they just
        // logged in, or are logged in via a remember me cookie
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        // ...
    }

    public function resetPassword()
    {
        // require the user to log in during *this* session
        // if they were only logged in via a remember me cookie, they
        // will be redirected to the login page
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // ...
    }


}
