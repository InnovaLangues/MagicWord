<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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

        return $this->render('MagicWordBundle:Game:ended.html.twig', ['games' => $games]);
    }

    /**
     * @Route("/game/{id}/forfeit", name="game_forfeit")
     */
    public function forfeitGameAction(Game $game)
    {
        $this->get('mw_manager.game')->forfeit($game);

        return $this->redirectToRoute('games_started');
    }

    /**
     * @Route("/game/{id}/export", name="game_export", options={"expose"=true})
     */
    public function exportGameAction(Game $game)
    {
        $gameJSON = $this->get('mw_manager.export')->exportGame($game);

        $response = new JsonResponse($gameJSON);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }

    /**
     * @Route("/game/import", name="json_import_form")
     * @Method("GET")
     */
    public function jsonImportFormAction()
    {
        return $this->render('MagicWordBundle:Game:import.html.twig');
    }

    /**
     * @Route("/game/import", name="json_import", options={"expose"=true})
     * @Method("POST")
     */
    public function jsonImportAction(Request $request)
    {
        $json = $request->get('json');

        if (!empty($json)) {
            $gameJSON = json_decode($json, true);
        }

        $gameId = $this->get('mw_manager.import')->importGame($gameJSON);

        $response = new JsonResponse(['id' => $gameId]);

        return $response;
    }
}
