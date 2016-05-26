<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GameController extends Controller
{
    /**
     * @Route("/games", name="games")
     */
    public function listAction()
    {
        $games = $this->getDoctrine()->getRepository('MagicWordBundle:Game')->findAll();

        return $this->render('MagicWordBundle:Game:list.html.twig', array('games' => $games));
    }
}
