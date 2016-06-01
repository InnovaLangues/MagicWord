<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\Round;

class RoundController extends Controller
{
    /**
     * @Route("/round/{id}/play", name="round_play")
     * @ParamConverter("round", class="MagicWordBundle:Round")
     */
    public function playAction(Round $round)
    {
        return $this->render('MagicWordBundle:Round:play.html.twig', array('round' => $round));
    }
}
