<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\Round;

class ActivityController extends Controller
{
    /**
     * @Route("/init-activity/{id}", name="init_activity", options={"expose"=true})
     * @ParamConverter("round", class="MagicWordBundle:Round")
     * @Method("POST")
     */
    public function initActivityAction(Round $round)
    {
        $delta = $this->get('mw_manager.activity')->init($round);

        return new JsonResponse(['delta' => $delta]);
    }

    /**
     * @Route("/add-found-form/{id}", name="add_foundForm", options={"expose"=true})
     * @ParamConverter("round", class="MagicWordBundle:Round")
     * @Method("POST")
     */
    public function addFoundFormAction(Round $round, Request $request)
    {
        $this->get('mw_manager.activity')->addFoundForm($round, $request);

        return new JsonResponse();
    }
}
