<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/round/{id}/edit", name="round_edit")
     * @ParamConverter("round", class="MagicWordBundle:Round")
     */
    public function editAction(Round $round)
    {
        $miscForm = $this->get('mw_manager.round')->getMiscForm($round);
        $form = $this->get('mw_manager.round')->getForm($round);

        return $this->render('MagicWordBundle:Round:edit.html.twig', ['round' => $round, 'miscForm' => $miscForm, 'form' => $form]);
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

    /**
     * @Route("/round/{id}/save-misc", name="save_misc" , options={"expose"=true})
     * @ParamConverter("round", class="MagicWordBundle:Round")
     */
    public function saveMiscAction(Round $round, Request $request)
    {
        $this->get('mw_manager.round')->handleMiscForm($round, $request);

        return new Response();
    }
}
