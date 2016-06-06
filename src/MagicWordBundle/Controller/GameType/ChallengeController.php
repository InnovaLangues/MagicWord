<?php

namespace MagicWordBundle\Controller\GameType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class ChallengeController extends Controller
{
    /**
     * @Route("/challenge", name="challenge")
     * @Method("GET")
     */
    public function challengeAction()
    {
        $form = $round = $this->get('mw_manager.challenge')->generateChallengeForm();

        return $this->render('MagicWordBundle:Game/Challenge:challenge.html.twig', array('form' => $form));
    }

    /**
     * @Route("/challenge", name="challenge_submit")
     * @Method("POST")
     */
    public function challengeSubmitAction(Request $request)
    {
        $this->get('mw_manager.challenge')->handleChallengeForm($request);

        return $this->redirectToRoute('challenges_sent');
    }

    /**
     * @Route("/challenges/sent", name="challenges_sent")
     * @Method("GET")
     */
    public function challengesSentAction()
    {
        $author = $this->get('security.token_storage')->getToken()->getUser();
        $challenges = $this->getDoctrine()->getRepository('MagicWordBundle:GameType\Challenge')->findByAuthor($author);

        return $this->render('MagicWordBundle:Game/Challenge:challenges-sent.html.twig', array('challenges' => $challenges));
    }

    /**
     * @Route("/challenges/received", name="challenges_received")
     * @Method("GET")
     */
    public function challengesReceivedAction()
    {
        $challenged = $this->get('security.token_storage')->getToken()->getUser();
        $challenges = $this->getDoctrine()->getRepository('MagicWordBundle:GameType\Challenge')->findByChallenged($challenged);

        return $this->render('MagicWordBundle:Game/Challenge:challenges-received.html.twig', array('challenges' => $challenges));
    }
}
