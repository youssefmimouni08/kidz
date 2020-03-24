<?php

namespace KidzyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Kidzy/Default/index.html.twig');
    }
}
