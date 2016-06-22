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
        $activity = $this->get('mw_manager.activity')->getActivity($round);

        if ($activity && $activity->getEndDate() != null) {
            return $this->redirectToRoute('round_end', ['id' => $round->getId()]);
        }

        return $this->render('MagicWordBundle:Round:play.html.twig', ['round' => $round]);
    }

    /**
     * @Route("/round/{id}/end", name="round_end", options={"expose"=true})
     * @ParamConverter("round", class="MagicWordBundle:Round")
     */
    public function endAction(Round $round)
    {
        $activity = $this->get('mw_manager.activity')->endActivity($round);

        return $this->render('MagicWordBundle:Round:end.html.twig', ['round' => $round, 'activity' => $activity]);
    }
}
