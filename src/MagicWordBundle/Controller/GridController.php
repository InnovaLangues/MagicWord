<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
    public function generateGrid()
    {
        $gm = $this->get('mw_manager.grid');
        $language = $this->getDoctrine()->getRepository('MagicWordBundle:Language')->find(1); //todo
        if ($grid = $gm->generate($language)) {
            return $this->redirectToRoute('grid', array('id' => $grid->getId()));
        }
    }

    /**
     * @Route("/create-grid", name="grid_create")
     */
    public function createGrid()
    {
        return $this->render('MagicWordBundle:Grid:create.html.twig');
    }
}
