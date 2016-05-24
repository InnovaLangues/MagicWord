<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Grid;
use MagicWordBundle\Entity\GameType\Training;

/**
 * @DI\Service("mw_manager.game")
 */
class GameManager
{
    protected $em;
    protected $gridManager;
    protected $roundManager;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "gridManager" = @DI\Inject("mw_manager.grid"),
     *      "roundManager" = @DI\Inject("mw_manager.round"),
     * })
     */
    public function __construct($entityManager, $gridManager, $roundManager)
    {
        $this->em = $entityManager;
        $this->gridManager = $gridManager;
        $this->roundManager = $roundManager;
    }

    public function generateTraining()
    {
        $game = new Training();

        $grid = $this->gridManager->seekOrGenerateForTraining();
        // pour l'instant on ne génère que des rush
        $round = $this->roundManager->generateRush($game, $grid);

        $game->setLanguage($grid->getLanguage());
        $this->em->persist($game);
        $this->em->flush();

        return $round;
    }
}
