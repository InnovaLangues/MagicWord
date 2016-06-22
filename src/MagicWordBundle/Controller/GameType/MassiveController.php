<?php

namespace MagicWordBundle\Controller\GameType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\GameType\Massive;
use MagicWordBundle\Entity\Round;

class MassiveController extends Controller
{
    /**
     * @Route("/massive/{id}/play", name="massive_play")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     */
    public function playAction(Massive $massive)
    {
        $this->get('mw_manager.user')->startGame($massive);
        $url = $this->get('mw_manager.massive')->getNextURL($massive);

        return $this->redirect($url);
    }

    /**
     * @Route("/massive/{id}/end", name="massive_end")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     */
    public function EndAction(Massive $massive)
    {
        $this->get('mw_manager.user')->endGame($massive);

        return $this->render('MagicWordBundle:Game/Massive:end.html.twig', array('massive' => $massive));
    }

    /**
     * @Route("/massive/{id}/ranking", name="massive_ranking")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     */
    public function rankingAction(Massive $massive)
    {
        return $this->render('MagicWordBundle:Game/Massive:ranking.html.twig', array('massive' => $massive));
    }

    /**
     * @Route("/massive/{id}/publish", name="massive_publish")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     */
    public function publishAction(Massive $massive)
    {
        $this->get('mw_manager.massive')->publish($massive);
        $this->get('session')->getFlashBag()->add('success', 'Partie massive publiée');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/massives", name="massives")
     * @Method("GET")
     */
    public function listMassivesAction()
    {
        $massives = $this->getDoctrine()->getRepository('MagicWordBundle:GameType\Massive')->findBy(['published' => 1]);

        return $this->render('MagicWordBundle:Game/Massive:list.html.twig', array('massives' => $massives));
    }

    /**
     * @Route("/my-massives-unpublished", name="my_massives_under_construction")
     * @Method("GET")
     */
    public function listMyMassivesUnpublishedAction()
    {
        $massives = $this->get('mw_manager.massive')->getMyMassives(false);

        return $this->render('MagicWordBundle:Game/Massive:my-list.html.twig', array('massives' => $massives));
    }

    /**
     * @Route("/my-massives-published", name="my_massives_published")
     * @Method("GET")
     */
    public function listMyMassivespublishedAction()
    {
        $massives = $this->get('mw_manager.massive')->getMyMassives(true);

        return $this->render('MagicWordBundle:Game/Massive:my-published-list.html.twig', array('massives' => $massives));
    }

    /**
     * @Route("/massive", name="massive")
     * @Method("GET")
     */
    public function createMassiveAction()
    {
        $form = $this->get('mw_manager.massive')->generateMassiveForm();

        return $this->render('MagicWordBundle:Game/Massive:form.html.twig', array('form' => $form));
    }

    /**
     * @Route("/massive", name="massive_submit")
     * @Method("POST")
     */
    public function massiveSubmitAction(Request $request)
    {
        $massive = $this->get('mw_manager.massive')->handleMassiveForm($request);
        $this->get('session')->getFlashBag()->add('success', 'Partie massive créée');

        return $this->redirectToRoute('massive_builder', array('id' => $massive->getId()));
    }

    /**
     * @Route("/massive/builder/{id}", name="massive_builder")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     */
    public function displayBuilderAction(Massive $massive)
    {
        return $this->render('MagicWordBundle:Game/Massive:builder.html.twig', array('massive' => $massive));
    }

    /**
     * @Route("/massive/{id}/add-rush", name="massive_add_rush")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     */
    public function addRushRoundAction(Massive $massive)
    {
        $this->get('mw_manager.massive')->addRushRound($massive);
        $this->get('session')->getFlashBag()->add('success', 'Round rush ajouté');

        return $this->redirectToRoute('massive_builder', array('id' => $massive->getId()));
    }

    /**
     * @Route("/massive/{massiveId}/remove/{roundId}", name="massive_remove_round")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive", options={"id" = "massiveId"})
     * @ParamConverter("round", class="MagicWordBundle:Round", options={"id" = "roundId"})
     */
    public function removeRoundAction(Massive $massive, Round $round)
    {
        $this->get('mw_manager.massive')->removeRound($massive, $round);
        $this->get('session')->getFlashBag()->add('success', 'Round supprimé');

        return $this->redirectToRoute('massive_builder', array('id' => $massive->getId()));
    }

    /**
     * @Route("/massive/{id}/add-conquer", name="massive_add_conquer")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     */
    public function addConquerRoundAction(Massive $massive)
    {
        $this->get('mw_manager.massive')->addConquerRound($massive);
        $this->get('session')->getFlashBag()->add('success', 'Round conquer ajouté');

        return $this->redirectToRoute('massive_builder', array('id' => $massive->getId()));
    }
}
