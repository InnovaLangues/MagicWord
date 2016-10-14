<?php

namespace  MagicWordBundle\Manager\GameType;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\GameType\Training;
use MagicWordBundle\Entity\Language;

/**
 * @DI\Service("mw_manager.training")
 */
class TrainingManager
{
    protected $em;
    protected $gridManager;
    protected $roundManager;
    protected $formFactory;
    protected $tokenStorage;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "gridManager"   = @DI\Inject("mw_manager.grid"),
     *      "roundManager"  = @DI\Inject("mw_manager.round"),
     *      "formFactory"   = @DI\Inject("form.factory"),
     *      "tokenStorage" = @DI\Inject("security.token_storage"),
     * })
     */
    public function __construct($entityManager, $gridManager, $roundManager, $formFactory, $tokenStorage)
    {
        $this->em = $entityManager;
        $this->gridManager = $gridManager;
        $this->roundManager = $roundManager;
        $this->formFactory = $formFactory;
        $this->tokenStorage = $tokenStorage;
    }

    public function generateTraining(Language $language)
    {
        $game = new Training();

        $grid = $this->gridManager->seekOrGenerateForTraining($language);
        $round = $this->roundManager->generateRush($game, $grid);
        $game->setLanguage($language);
        $game->setAuthor($this->tokenStorage->getToken()->getUser());
        $this->em->persist($game);
        $this->em->flush();

        return $round;
    }
}
