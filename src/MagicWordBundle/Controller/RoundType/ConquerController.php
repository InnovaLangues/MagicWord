<?php

namespace MagicWordBundle\Controller\RoundType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\RoundType\Conquer;
use MagicWordBundle\Form\Type\RoundType;

class ConquerController extends Controller
{
    /**
     * @Route("/conquer/{id}", name="conquer")
     * @ParamConverter("conquer", class="MagicWordBundle:RoundType\Conquer")
     */
    public function displayConquerAction(Conquer $conquer)
    {
        $form = $this->createForm(RoundType::class, $conquer)->createView();

        return $this->render('MagicWordBundle:Round/Conquer:edit.html.twig',
            [
                'conquer' => $conquer,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/conquer/{id}/save-grid", name="conquer_save_grid" , options={"expose"=true})
     * @ParamConverter("conquer", class="MagicWordBundle:RoundType\Conquer")
     */
    public function saveConquerGridAction(Conquer $conquer, Request $request)
    {
        $this->get('mw_manager.round')->saveConquerGrid($conquer, $request);
        $foundableForms = $conquer->getGrid()->getFoundableForms();
        $template = $this->get('templating')->render('MagicWordBundle:Round/Conquer/Objective:possible-inflections.html.twig', ['foundableForms' => $foundableForms]);

        return new Response($template);
    }

    /**
     * @Route("/conquer/{id}/save-objectives", name="save_objectives" , options={"expose"=true})
     * @ParamConverter("conquer", class="MagicWordBundle:RoundType\Conquer")
     */
    public function saveObjectivesAction(Conquer $conquer, Request $request)
    {
        $this->get('mw_manager.objective')->saveObjectives($conquer, $request);

        return new Response();
    }
}
