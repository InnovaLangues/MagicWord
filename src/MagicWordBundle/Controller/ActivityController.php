<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\Round;
use MagicWordBundle\Entity\Objective;
use MagicWordBundle\Entity\FoundableForm;
use MagicWordBundle\Entity\Rules\ComboPoints;
use MagicWordBundle\Entity\Activity;

class ActivityController extends Controller
{
    /**
     * @Route("/init-activity/{id}", name="init_activity", options={"expose"=true})
     * @ParamConverter("round", class="MagicWordBundle:Round")
     * @Method("POST")
     */
    public function initActivityAction(Round $round)
    {
        $activityInfo = $this->get('mw_manager.activity')->init($round);

        return new JsonResponse($activityInfo);
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

    /**
     * @Route("/add-wrong-form/round/{roundId}/form/{form}", name="add_wrongForm", options={"expose"=true})
     * @ParamConverter("round", class="MagicWordBundle:Round",  options={"id" = "roundId"})
     * @Method("POST")
     */
    public function addWrongFormAction(Round $round, $form)
    {
        $this->get('mw_manager.activity')->addWrongForm($round, $form);

        return new JsonResponse();
    }

    /**
     * @Route("/add-objective-done/round/{roundId}/objective/{objectiveId}", name="add_objectiveDone", options={"expose"=true})
     * @ParamConverter("round", class="MagicWordBundle:Round",  options={"id" = "roundId"})
     * @ParamConverter("objective", class="MagicWordBundle:Objective", options={"id" = "objectiveId"})
     * @Method("POST")
     */
    public function addObjectiveDoneAction(Round $round, Objective $objective)
    {
        $this->get('mw_manager.activity')->addObjectiveDone($round, $objective);

        return new JsonResponse();
    }

    /**
     * @Route("/add-combo-points/round/{roundId}/length/{length}", name="add_combopoints", options={"expose"=true})
     * @ParamConverter("round", class="MagicWordBundle:Round",  options={"id" = "roundId"})
     * @ParamConverter("comboPoints", class="MagicWordBundle:Rules\ComboPoints", options={"length" = "length"})
     * @Method("POST")
     */
    public function addComboPointsAction(Round $round, ComboPoints $comboPoints)
    {
        $this->get('mw_manager.activity')->addComboPoints($round, $comboPoints);

        return new JsonResponse(['points' => $comboPoints->getPoints()]);
    }

    /**
     * @Route("/save-combo-finished/round/{roundId}/length/{length}", name="save_combo_finished", options={"expose"=true})
     * @ParamConverter("round", class="MagicWordBundle:Round",  options={"id" = "roundId"})
     * @ParamConverter("comboPoints", class="MagicWordBundle:Rules\ComboPoints", options={"length" = "length"})
     * @Method("POST")
     */
    public function saveComboFinishedAction(Round $round, ComboPoints $comboPoints)
    {
        $this->get('mw_manager.activity')->saveComboFinished($round, $comboPoints);

        return new JsonResponse(['points' => $comboPoints->getPoints()]);
    }

    /**
     * @Route("/activity/{activityId}/display", name="activity_display", options={"expose"=true})
     * @ParamConverter("activity", class="MagicWordBundle:Activity",  options={"id" = "activityId"})
     * @Method("GET")
     */
    public function activityDisplayAction(Activity $activity)
    {
        $canAccessScores = $this->get('mw_manager.activity')->canAccessScores($activity);
        if ($canAccessScores) {
            $activity = $this->renderView('MagicWordBundle:Activity:details.html.twig', ['activity' => $activity]);

            return new Response($activity);
        }

        return new Response();
    }
}
