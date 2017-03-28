<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Round;
use MagicWordBundle\Entity\Game;

/**
 * @DI\Service("mw_manager.export")
 */
class ExportManager
{
    protected $em;
    protected $gridManager;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "gridManager"   = @DI\Inject("mw_manager.grid"),
     * })
     */
    public function __construct($entityManager, $gridManager)
    {
        $this->em = $entityManager;
        $this->gridManager = $gridManager;
    }

    public function exportGame(Game $game)
    {
        $gameJSON = [
            'name' => $game->getName(),
            'description' => $game->getDescription(),
            'language' => $game->getLanguage()->getId(),
            'access' => $game->getAccessType()->getId(),
            'rounds' => [],
        ];

        foreach ($game->getRounds() as $round) {
            $gameJSON['rounds'][] = $this->exportRound($round);
        }

        return $gameJSON;
    }

    public function exportRound(Round $round)
    {
        $roundJSON = [
            'title' => $round->getTitle(),
            'description' => $round->getDescription(),
            'language' => $round->getLanguage()->getId(),
            'type' => $round->getDiscr(),
            'displayOrder' => $round->getDisplayOrder(),
            'grid' => null,
            'objectives' => [],
        ];

        $roundJSON['grid'] = $this->gridManager->export($round->getGrid());

        if ($roundJSON['type'] == 'conquer') {
            foreach ($round->getObjectives() as $objective) {
                $roundJSON['objectives'][] = $this->exportObjective($objective);
            }
        }

        return $roundJSON;
    }

    public function exportObjective($objective)
    {
        $objectiveJSON = $objective->export();

        return $objectiveJSON;
    }
}
