<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/home", name="home")
     */
    public function homeAction()
    {
        return $this->render('MagicWordBundle:Default:home.html.twig');
    }

    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('MagicWordBundle:Default:index.html.twig');
    }
}
