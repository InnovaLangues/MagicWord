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
    protected $currentUser;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "tokenStorage" = @DI\Inject("security.token_storage"),
     *      "userManager" = @DI\Inject("mw_manager.user"),
     * })
     */
    public function __construct($entityManager, $tokenStorage, $userManager)
    {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->userManager = $userManager;
        $this->currentUser = $this->tokenStorage->getToken()->getUser();
    }

    public function forfeit(Game $game)
    {
        $this->userManager->endGame($game, true);

        return;
    }
}
