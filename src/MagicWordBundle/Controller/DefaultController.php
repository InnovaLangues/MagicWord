<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="hello")
     */
    public function indexAction()
    {
        return $this->render('MagicWordBundle:Default:index.html.twig');
    }
}
