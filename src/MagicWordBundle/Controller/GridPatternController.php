<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use MagicWordBundle\Entity\GridPattern;

class GridPatternController extends Controller
{
    /**
     * @Route("/pattern/mine", name="get_my_patterns", options={"expose"=true})
     * @Method("GET")
     */
    public function getMyPatternsAction()
    {
        $patterns = $this->get('mw_manager.grid_pattern')->getMine();
        $template = $this->get('templating')->render('MagicWordBundle:Grid:grid-pattern-list.html.twig', array('patterns' => $patterns ));

        return new Response($template);
    }

    /**
     * @Route("/pattern/all", name="get_all_patterns", options={"expose"=true})
     * @Method("GET")
     */
    public function getAllPatternsAction()
    {
        $patterns = $this->get('mw_manager.grid_pattern')->getAll();
        $template = $this->get('templating')->render('MagicWordBundle:Grid:grid-pattern-list.html.twig', array('patterns' => $patterns ));

        return new Response($template);
    }

    /**
     * @Route("/pattern/{id}/form", name="pattern_form", options={"expose"=true})
     * @Method("GET")
     */
    public function patternFormAction(GridPattern $gridPattern)
    {
        $form = $this->get('mw_manager.grid_pattern')->getForm($gridPattern);
        $template = $this->get('templating')->render('MagicWordBundle:Grid:grid-pattern-edit.html.twig', array('form' => $form, 'pattern' => $gridPattern ));

        return new Response($template);
    }

    /**
     * @Route("/pattern/{id}/save", name="pattern_save", options={"expose"=true})
     * @Method("POST")
     */
    public function savePatternAction(GridPattern $gridPattern, Request $request)
    {
        $this->get('mw_manager.grid_pattern')->save($gridPattern, $request);

        return new JsonResponse();
    }

    /**
     * @Route("/pattern/create-form", name="pattern_create_form", options={"expose"=true})
     * @Method("GET")
     */
    public function patternCreateFormAction()
    {
        $gridPattern = new GridPattern();
        $form = $this->get('mw_manager.grid_pattern')->getForm($gridPattern);
        $template = $this->get('templating')->render('MagicWordBundle:Grid:grid-pattern-edit.html.twig', array('form' => $form, 'pattern' => $gridPattern ));

        return new Response($template);
    }

    /**
     * @Route("/pattern/create-form", name="pattern_create", options={"expose"=true})
     * @Method("POST")
     */
    public function patternCreateAction(Request $request)
    {
        $gridPattern = new GridPattern();
        $this->get('mw_manager.grid_pattern')->save($gridPattern, $request);
        $form = $this->get('mw_manager.grid_pattern')->getForm($gridPattern);

        $template = $this->get('templating')->render('MagicWordBundle:Grid:grid-pattern-edit.html.twig', array('form' => $form, 'pattern' => $gridPattern ));

        return new Response($template);
    }

    /**
     * @Route("/pattern/{id}/delete", name="pattern_delete", options={"expose"=true})
     * @Method("DELETE")
     */
    public function patternDeleteAction(GridPattern $gridPattern)
    {
        $this->get('mw_manager.grid_pattern')->delete($gridPattern);

        return new Response();
    }
}
