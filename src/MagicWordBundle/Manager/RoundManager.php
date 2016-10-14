<?php

namespace  MagicWordBundle\Manager;

use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Game;
use MagicWordBundle\Entity\Grid;
use MagicWordBundle\Entity\Round;
use MagicWordBundle\Entity\RoundType\Rush;
use MagicWordBundle\Entity\RoundType\Conquer;
use MagicWordBundle\Form\Type\RoundMiscType;
use MagicWordBundle\Form\Type\RoundType;

/**
 * @DI\Service("mw_manager.round")
 */
class RoundManager
{
    protected $em;
    protected $gridManager;
    protected $formFactory;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "gridManager"   = @DI\Inject("mw_manager.grid"),
     *      "formFactory"   = @DI\Inject("form.factory"),
     * })
     */
    public function __construct($entityManager, $gridManager, $formFactory)
    {
        $this->em = $entityManager;
        $this->gridManager = $gridManager;
        $this->formFactory = $formFactory;
    }

    public function getData(Round $round)
    {
        $grid = $round->getGrid();
        $data = array();
        $data['inflections'] = json_encode($grid, JSON_PRETTY_PRINT);
        $data['objectives'] = json_encode($round, JSON_PRETTY_PRINT);

        return $data;
    }

    public function generateRush(Game $game, Grid $grid)
    {
        $round = new Rush();
        $round->setGame($game);
        $round->setGrid($grid);
        $round->setDisplayOrder($this->getNextDisplayOrder($game));
        $round->setLanguage($game->getLanguage());
        $this->em->persist($round);
        $this->em->flush();

        return $round;
    }

    public function generateConquer(Game $game)
    {
        $round = new Conquer();
        $round->setGame($game);
        $round->setGrid(null);
        $round->setDisplayOrder($this->getNextDisplayOrder($game));
        $round->setLanguage($game->getLanguage());

        $this->em->persist($round);
        $this->em->flush();

        return $round;
    }

    public function saveConquerGrid(Conquer $conquer, Request $request)
    {
        if (!$grid = $conquer->getGrid()) {
            $grid = $this->gridManager->createGrid($request, true);
            $conquer->setGrid($grid);
            $this->em->persist($conquer);
            $this->em->flush();
        } else {
            $this->gridManager->updateGrid($grid, $request);
        }

        $this->em->refresh($grid);

        return $grid;
    }

    private function getNextDisplayOrder(Game $game)
    {
        return $game->getRounds()->count();
    }

    public function getMiscForm(Round $round)
    {
        $form = $this->formFactory->createBuilder(RoundMiscType::class, $round)->getForm()->createView();

        return $form;
    }

    public function handleMiscForm(Round $round, Request $request)
    {
        $form = $this->formFactory->createBuilder(RoundMiscType::class, $round)->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($round);
            $this->em->flush();
        }

        return;
    }

    public function getForm(Round $round)
    {
        return $form = ($round->getDiscr() == 'conquer')
            ? $this->formFactory->createBuilder(RoundType::class, $round)->getForm()->createView()
            : null;
    }

    public function isValid(Round $round)
    {
        $errors = [];
        $roundName = $round->getDisplayOrder() + 1;
        if (!$round->getGrid()) {
            $errors[] = 'missing grid for round '.$roundName;
        }

        if ($round->getDiscr() == 'conquer' && count($round->getObjectives()) == 0) {
            $errors[] = 'missing objectives for round '.$roundName;
        }

        return $errors;
    }
}
