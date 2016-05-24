<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Grid;
use MagicWordBundle\Entity\GameType\Training;
use MagicWordBundle\Entity\GameType\Challenge;

/**
 * @DI\Service("mw_manager.game")
 */
class GameManager
{
    protected $em;
    protected $gridManager;
    protected $roundManager;
    protected $formFactory;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "gridManager"   = @DI\Inject("mw_manager.grid"),
     *      "roundManager"  = @DI\Inject("mw_manager.round"),
     *      "formFactory"   = @DI\Inject("form.factory"),
     * })
     */
    public function __construct($entityManager, $gridManager, $roundManager, $formFactory)
    {
        $this->em = $entityManager;
        $this->gridManager = $gridManager;
        $this->roundManager = $roundManager;
        $this->formFactory = $formFactory;
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

    public function generateForm()
    {
        $form = $this->formFactory->createBuilder('MagicWordBundle\Form\Type\ChallengeType', new Challenge())->getForm()->createView();

        return $form;
    }
}
