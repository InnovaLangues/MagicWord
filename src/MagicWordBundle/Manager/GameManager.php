<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Game;

/**
 * @DI\Service("mw_manager.game")
 */
class GameManager
{
    protected $em;
    protected $tokenStorage;
    protected $userManager;
    protected $activityManager;
    protected $roundManager;
    protected $currentUser;

    /**
     * @DI\InjectParams({
     *      "entityManager"         = @DI\Inject("doctrine.orm.entity_manager"),
     *      "tokenStorage"          = @DI\Inject("security.token_storage"),
     *      "userManager"           = @DI\Inject("mw_manager.user"),
     *      "activityManager"      = @DI\Inject("mw_manager.activity"),
     *      "roundManager"          = @DI\Inject("mw_manager.round")
     * })
     */
    public function __construct($entityManager, $tokenStorage, $userManager, $activityManager, $roundManager)
    {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->userManager = $userManager;
        $this->activityManager = $activityManager;
        $this->roundManager = $roundManager;
        $this->currentUser = $this->tokenStorage->getToken()->getUser();
    }

    public function forfeit(Game $game)
    {
        $this->closeOpenedRound($game);
        $this->userManager->endGame($game, true);

        return;
    }

    public function export(Game $game)
    {
        $gameJSON = [
            'name' => $game->getName(),
            'description' => $game->getDescription(),
            'language' => $game->getLanguage()->getId(),
            'access' => $game->getAccessType()->getId(),
            'rounds' => [],
        ];

        foreach ($game->getRounds() as $round) {
            $gameJSON['rounds'][] = $this->roundManager->export($round);
        }

        return $gameJSON;
    }

    private function closeOpenedRound(Game $game)
    {
        foreach ($game->getRounds() as $round) {
            $activity = $this->em->getRepository('MagicWordBundle:Activity')->findOneBy(['player' => $this->currentUser, 'round' => $round]);
            if ($activity && $activity->getEndDate() == null) {
                $this->activityManager->endActivity($round);
                break;
            }
        }

        return;
    }
}
