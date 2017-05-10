<?php

namespace MagicWordBundle\Controller\GameType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use MagicWordBundle\Entity\GameType\Challenge;
use MagicWordBundle\Entity\Player;

class ChallengeController extends Controller
{
    /**
     * @Route("/challenge", name="challenge")
     * @Method("GET")
     */
    public function challengeAction(Request $request)
    {
        $form = $this->get('mw_manager.challenge')->handleChallengeForm($request);

        return $this->render('MagicWordBundle:Game/Challenge:challenge.html.twig', array('form' => $form));
    }

    /**
     * @Route("/challenge", name="challenge_submit")
     * @Method("POST")
     */
    public function challengeSubmitAction(Request $request)
    {
        $this->get('mw_manager.challenge')->handleChallengeForm($request);

        return $this->redirectToRoute('games_started');
    }

    /**
     * @Route("/challenge/{id}", name="challenge_someone")
     * @Method("GET")
     */
    public function challengeSomeoneAction(Player $challenged, Request $request)
    {
        $form = $this->get('mw_manager.challenge')->handleChallengeForm($request, $challenged);

        return $this->render('MagicWordBundle:Game/Challenge:challenge.html.twig', array('form' => $form));
    }

    /**
     * @Route("/challenge/{id}/play", name="challenge_continue")
     * @Method("GET")
     */
    public function playChallengeAction(Challenge $challenge)
    {
        if ($this->get('mw_manager.user')->canPlay($challenge)) {
            $url = $this->get('mw_manager.challenge')->getNextURL($challenge);

            return $this->redirect($url);
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/challenge/{id}/reply", name="challenge_reply")
     * @Method("GET")
     */
    public function replyChallengeAction(Challenge $challenge)
    {
        $form = $this->get('mw_manager.challenge')->generateReplyForm($challenge);

        return $this->render('MagicWordBundle:Game/Challenge:reply.html.twig', array('form' => $form));
    }

    /**
     * @Route("/challenge/{id}/reply", name="challenge_reply_submit")
     * @Method("POST")
     */
    public function replyChallengeSubmitAction(Challenge $challenge, Request $request)
    {
        $this->get('mw_manager.challenge')->handleReplyForm($challenge, $request);

        return $this->redirectToRoute('games_started');
    }

    /**
     * @Route("/challenge/{id}/end", name="challenge_end")
     */
    public function endAction(Challenge $challenge)
    {
        $this->get('mw_manager.user')->endGame($challenge);

        return $this->render('MagicWordBundle:Game:end.html.twig', array('massive' => $challenge));
    }

    /**
     * @Route("/challenge/{id}/decline", name="challenge_decline")
     */
    public function declineAction(Challenge $challenge)
    {
        $this->get('session')->getFlashBag()->add('success', 'Défi refusé');
        $this->get('mw_manager.challenge')->decline($challenge);

        return $this->redirectToRoute('games_started');
    }

    /**
     * @Route("/challenge/{id}/cancel", name="challenge_cancel")
     */
    public function cancelAction(Challenge $challenge)
    {
        $this->get('mw_manager.challenge')->cancel($challenge);

        return $this->redirectToRoute('games_started');
    }
}
