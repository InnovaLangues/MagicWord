<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\Round;
use MagicWordBundle\Entity\FoundableForm;

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
     * @Route("/add-found-form/round/{roundId}/foundable/{foundableId}", name="add_foundForm", options={"expose"=true})
     * @ParamConverter("round", class="MagicWordBundle:Round",  options={"id" = "roundId"})
     * @ParamConverter("foundableForm", class="MagicWordBundle:FoundableForm", options={"id" = "foundableId"})
     * @Method("POST")
     */
    public function addFoundFormAction(Round $round, FoundableForm $foundableForm)
    {
        $this->get('mw_manager.activity')->addFoundForm($round, $foundableForm);

        return new JsonResponse();
    }
}
