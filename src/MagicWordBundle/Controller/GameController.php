<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MagicWordBundle\Entity\Game;

class GameController extends Controller
{
    /**
     * @Route("/games/started", name="games_started")
     */
    public function listStartedGamesAction()
    {
        $games = $this->get('security.token_storage')->getToken()->getUser()->getStartedGames();

        return $this->render('MagicWordBundle:Game:started.html.twig', array('games' => $games));
    }

    /**
     * @Route("/games/ended", name="games_ended")
     */
    public function listEndedGamesAction()
    {
        $games = $this->get('security.token_storage')->getToken()->getUser()->getEndedGames();

        return $this->render('MagicWordBundle:Game:ended.html.twig', array('games' => $games));
    }

    /**
     * @Route("/game/{id}/forfeit", name="game_forfeit")
     */
    public function forfeitGameAction(Game $game)
    {
        $this->get('mw_manager.game')->forfeit($game);

        return $this->redirectToRoute('games_started');
    }
}
