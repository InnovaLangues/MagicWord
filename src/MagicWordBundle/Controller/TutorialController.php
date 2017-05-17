<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TutorialController extends Controller
{
    /**
     * @Route("/tutorial", name="tutorial", options={"expose"=true})
     * @Method("GET")
     */
    public function playTutorialAction()
    {
        $generalParameters = $this->get("mw_manager.administration")->getGeneralParameters();
        $round = $generalParameters->getTutorial()->getRounds()[0];

        return $this->render('MagicWordBundle:Round:tutorial.html.twig', ['round' => $round]);
    }
}
