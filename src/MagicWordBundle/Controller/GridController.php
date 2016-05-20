<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use MagicWordBundle\Entity\Grid;

class GridController extends Controller
{
    /**
     * @Route("/grid/{id}", name="grid")
     * @ParamConverter("grid", class="MagicWordBundle:Grid")
     */
    public function getInfosAction(Grid $grid)
    {
        return $this->render('MagicWordBundle:Grid:index.html.twig', array('grid' => $grid));
    }

    /**
     * @Route("/grids", name="grids")
     */
    public function listAction()
    {
        $grids = $this->getDoctrine()->getRepository('MagicWordBundle:Grid')->findAll();

        return $this->render('MagicWordBundle:Grid:list.html.twig', array('grids' => $grids));
    }

    /**
     * @Route("/generate-grid", name="grid_generate")
     */
    public function generateGridAction()
    {
        $language = $this->getDoctrine()->getRepository('MagicWordBundle:Language')->find(1); //todo
        $grid = $this->get('mw_manager.grid')->generate($language);

        return $this->redirectToRoute('grid', array('id' => $grid->getId()));
    }

    /**
     * @Route("/create-grid", name="grid_create")
     * @Method("GET")
     */
    public function displayGridFormAction()
    {
        return $this->render('MagicWordBundle:Grid:create.html.twig');
    }

    /**
     * @Route("/create-grid", name="grid_create_post")
     * @Method("POST")
     */
    public function createGridAction(Request $request)
    {
        $grid = $this->get('mw_manager.grid')->createGrid($request);

        return $this->redirectToRoute('grid', array('id' => $grid->getId()));
    }
}
