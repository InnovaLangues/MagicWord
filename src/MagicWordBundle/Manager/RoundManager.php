<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Game;
use MagicWordBundle\Entity\Grid;
use MagicWordBundle\Entity\RoundType\Rush;

/**
 * @DI\Service("mw_manager.round")
 */
class RoundManager
{
    protected $em;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     * })
     */
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    public function generateRush(Game $game, Grid $grid)
    {
        $round = new Rush();
        $round->setGame($game);
        $round->setGrid($grid);
        $round->setDisplayOrder($this->getNextDisplayOrder($game));
        $this->em->persist($round);
        $this->em->flush();

        return $round;
    }

    private function getNextDisplayOrder(Game $game)
    {
        return $game->getRounds()->count();
    }
}
