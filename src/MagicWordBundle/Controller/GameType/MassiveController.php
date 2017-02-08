<?php

namespace MagicWordBundle\Controller\GameType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\GameType\Massive;
use MagicWordBundle\Entity\Round;
use MagicWordBundle\Form\Type\MassiveType;

class MassiveController extends Controller
{
    /**
     * @Route("/massive/{code}/play", name="massive_play")
     * @ParamConverter("massive", options={"mapping": {"code": "code"}})
     */
    public function playAction(Massive $massive)
    {
        if ($this->get('mw_manager.user')->canPlay($massive)) {
            $this->get('mw_manager.user')->startGame($massive);
            $url = $this->get('mw_manager.massive')->getNextURL($massive);

            return $this->redirect($url);
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/massive/{id}/end", name="massive_end")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     */
    public function endAction(Massive $massive)
    {
        $this->get('mw_manager.user')->endGame($massive);

        return $this->render('MagicWordBundle:Game:end.html.twig', array('massive' => $massive));
    }

    /**
     * @Route("/massive/{id}/summary", name="massive_summary")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     */
    public function summaryAction(Massive $massive)
    {
        if (!$this->get('mw_manager.user')->isGranted($massive)) {
            return $this->redirectToRoute('home');
        }

        return $this->render('MagicWordBundle:Game/Massive:summary.html.twig', array('massive' => $massive));
    }

    /**
     * @Route("/massive/{id}/publish", name="massive_publish")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     */
    public function publishAction(Massive $massive)
    {
        if (!$this->get('mw_manager.user')->isGranted($massive)) {
            return $this->redirectToRoute('home');
        }

        $errors = $this->get('mw_manager.massive')->publish($massive);

        if (empty($errors)) {
            $this->get('session')->getFlashBag()->add('success', 'Partie massive publiée');
            $response = $this->redirectToRoute('home');
        } else {
            $this->get('session')->getFlashBag()->add('warning', 'Erreur de publication ('.implode(' | ', $errors).')');
            $response = $this->redirectToRoute('massive_builder', array('id' => $massive->getId()));
        }

        return $response;
    }

    /**
     * @Route("/massives", name="massives")
     * @Method("GET")
     */
    public function listMassivesAction()
    {
        $massives = $this->getDoctrine()->getRepository('MagicWordBundle:GameType\Massive')->findBy(['published' => 1, 'accessType' => 1]);

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
     * @Method("GET")
     */
    public function displayBuilderAction(Massive $massive)
    {
        if (!$this->get('mw_manager.user')->isGranted($massive)) {
            return $this->redirectToRoute('home');
        }

        $form = $this->get('form.factory')->createBuilder(MassiveType::class, $massive)->getForm()->createView();

        return $this->render('MagicWordBundle:Game/Massive:builder.html.twig', array('massive' => $massive, 'form' => $form));
    }

    /**
     * @Route("/massive/builder/{id}", name="massive_saveinfo")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     * @Method("POST")
     */
    public function saveInfosAction(Massive $massive, Request $request)
    {
        if (!$this->get('mw_manager.user')->isGranted($massive)) {
            return $this->redirectToRoute('home');
        }

        $massive = $this->get('mw_manager.massive')->handleMassiveForm($request, $massive);

        return $this->redirectToRoute('massive_builder', array('id' => $massive->getId()));
    }

    /**
     * @Route("/massive/{id}/add-rush", name="massive_add_rush")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive")
     */
    public function addRushRoundAction(Massive $massive)
    {
        if (!$this->get('mw_manager.user')->isGranted($massive)) {
            return $this->redirectToRoute('home');
        }

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
        if (!$this->get('mw_manager.user')->isGranted($massive)) {
            return $this->redirectToRoute('home');
        }

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
        if (!$this->get('mw_manager.user')->isGranted($massive)) {
            return $this->redirectToRoute('home');
        }

        $this->get('mw_manager.massive')->addConquerRound($massive);
        $this->get('session')->getFlashBag()->add('success', 'Round conquer ajouté');

        return $this->redirectToRoute('massive_builder', array('id' => $massive->getId()));
    }

    /**
     * @Route("/massive/{massiveId}/moveup/{roundId}", name="round_move_up")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive", options={"id" = "massiveId"})
     * @ParamConverter("round", class="MagicWordBundle:Round", options={"id" = "roundId"})
     */
    public function roundMoveUpAction(Massive $massive, Round $round)
    {
        if (!$this->get('mw_manager.user')->isGranted($massive)) {
            return $this->redirectToRoute('home');
        }

        $this->get('mw_manager.massive')->swapRound($massive, $round, -1);
        $this->get('session')->getFlashBag()->add('success', 'Round déplacé');

        return $this->redirectToRoute('massive_builder', array('id' => $massive->getId()));
    }

    /**
     * @Route("/massive/{massiveId}/movedown/{roundId}", name="round_move_down")
     * @ParamConverter("massive", class="MagicWordBundle:GameType\Massive", options={"id" = "massiveId"})
     * @ParamConverter("round", class="MagicWordBundle:Round", options={"id" = "roundId"})
     */
    public function roundMoveDownAction(Massive $massive, Round $round)
    {
        if (!$this->get('mw_manager.user')->isGranted($massive)) {
            return $this->redirectToRoute('home');
        }

        $this->get('mw_manager.massive')->swapRound($massive, $round, 1);
        $this->get('session')->getFlashBag()->add('success', 'Round déplacé');

        return $this->redirectToRoute('massive_builder', array('id' => $massive->getId()));
    }
}
