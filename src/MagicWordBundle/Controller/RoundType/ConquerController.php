<?php

namespace MagicWordBundle\Controller\RoundType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\RoundType\Conquer;
use Symfony\Component\HttpFoundation\Response;

class ConquerController extends Controller
{
    /**
     * @Route("/conquer/{id}", name="conquer")
     * @ParamConverter("conquer", class="MagicWordBundle:RoundType\Conquer")
     */
    public function displayConquerAction(Conquer $conquer)
    {
        return $this->render('MagicWordBundle:Round/Conquer:edit.html.twig', array('conquer' => $conquer));
    }

    /**
     * @Route("/conquer/{id}/save-grid", name="conquer_save_grid" , options={"expose"=true})
     * @ParamConverter("conquer", class="MagicWordBundle:RoundType\Conquer")
     */
    public function saveConquerGridAction(Conquer $conquer, Request $request)
    {
        $this->get('mw_manager.round')->saveConquerGrid($conquer, $request);
        $inflections = $this->get('mw_manager.grid')->getInflections($request);
        $template = $this->get('templating')->render('MagicWordBundle:Lexicon:inflections.html.twig', array('inflections' => $inflections));

        return new Response($template);
    }
}
