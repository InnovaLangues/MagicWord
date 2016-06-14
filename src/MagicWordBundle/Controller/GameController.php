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

    /**
     * @Route("/games/unfinished", name="unfinished_games")
     */
    public function UnifinishedGamesAction()
    {
        $games = $this->getDoctrine()->getRepository('MagicWordBundle:Game')->getUnfinished($this->get('security.token_storage')->getToken()->getUser());

        return $this->render('MagicWordBundle:Game/Massive:list.html.twig', array('massives' => $games));
    }
}
