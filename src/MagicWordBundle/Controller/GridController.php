<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use MagicWordBundle\Entity\Grid;

class GridController extends Controller
{
    /**
     * @Route("/get-inflections", name="get_inflections", options={"expose"=true})
     * @Method("POST")
     */
    public function getInflectionAction(Request $request)
    {
        $foundableForms = $this->get('mw_manager.grid')->getFoundableForms($request);

        $template = $this->get('templating')->render('MagicWordBundle:Round/Conquer/Objective:possible-inflections.html.twig', array('foundableForms' => $foundableForms));

        return new Response($template);
    }

    /**
     * @Route("/get-combos", name="get_combos", options={"expose"=true})
     * @Method("POST")
     */
    public function getCombosAction(Request $request)
    {
        $combos = $this->get('mw_manager.grid')->getCombos($request);

        $template = $this->get('templating')->render('MagicWordBundle:Round/Conquer/Objective:possible-combos.html.twig', array('combos' => $combos));

        return new Response($template);
    }

    /**
     * @Route("/render-grid", name="render_grid", options={"expose"=true})
     * @Method("POST")
     */
    public function renderGridAction(Request $request)
    {
        $grid = $this->get('mw_manager.grid')->createGrid($request, false);

        $template = $this->get('templating')->render('MagicWordBundle:Round/Conquer:grid.html.twig', array('grid' => $grid));

        return new Response($template);
    }
}
