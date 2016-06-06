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
     * @Route("/massives", name="massives")
     * @Method("GET")
     */
    public function listMassivesAction()
    {
        $massives = $this->getDoctrine()->getRepository('MagicWordBundle:GameType\Massive')->findAll();

        return $this->render('MagicWordBundle:Game/Massive:list.html.twig', array('massives' => $massives));
    }

    /**
     * @Route("/my-massives", name="my_massives")
     * @Method("GET")
     */
    public function listMyMassivesAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $massives = $this->getDoctrine()->getRepository('MagicWordBundle:GameType\Massive')->findByAuthor($user);

        return $this->render('MagicWordBundle:Game/Massive:my-list.html.twig', array('massives' => $massives));
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
