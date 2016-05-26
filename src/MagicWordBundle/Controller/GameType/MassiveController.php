<?php

namespace MagicWordBundle\Controller\GameType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\GameType\Massive;

class MassiveController extends Controller
{
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

        return $this->redirectToRoute('massive_builder', array('id' => $massive->getId()));
    }
}
