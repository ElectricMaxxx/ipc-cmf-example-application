<?php

namespace IPCApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('IPCApplicationBundle:Default:index.html.twig', array('name' => $name));
    }

    public function routeOnlyAction()
    {
        return $this->render('IPCApplicationBundle:Default:index.html.twig', array('name' => 'Route only example'));
    }
}
