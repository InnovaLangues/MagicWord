<?php

namespace  MagicWordBundle\Manager\GameType;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\GameType\Challenge;
use MagicWordBundle\Form\Type\ChallengeType;
use MagicWordBundle\Form\Type\ChallengeReplyType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @DI\Service("mw_manager.challenge")
 */
class ChallengeManager
{
    protected $em;
    protected $gridManager;
    protected $roundManager;
    protected $objectiveManager;
    protected $formFactory;
    protected $tokenStorage;
    protected $router;
    protected $userManager;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "gridManager"   = @DI\Inject("mw_manager.grid"),
     *      "roundManager"  = @DI\Inject("mw_manager.round"),
     *      "objectiveManager"  = @DI\Inject("mw_manager.objective"),
     *      "formFactory"   = @DI\Inject("form.factory"),
     *      "tokenStorage"  = @DI\Inject("security.token_storage"),
     *      "router"        = @DI\Inject("router"),
     *      "userManager"   = @DI\Inject("mw_manager.user")
     * })
     */
    public function __construct($entityManager, $gridManager, $roundManager, $objectiveManager, $formFactory, $tokenStorage, $router, $userManager)
    {
        $this->em = $entityManager;
        $this->gridManager = $gridManager;
        $this->roundManager = $roundManager;
        $this->objectiveManager = $objectiveManager;
        $this->formFactory = $formFactory;
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->userManager = $userManager;
    }

    public function decline(Challenge $challenge)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user === $challenge->getChallenged()) {
            $this->removeFromStarted($challenge);
            $this->remove($challenge);
        }

        return;
    }

    public function cancel(Challenge $challenge)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user === $challenge->getAuthor()) {
            $this->removeFromStarted($challenge);
            $this->remove($challenge);
        }

        return;
    }

    private function removeFromStarted(Challenge $challenge)
    {
        $this->userManager->removeFromStarted($challenge, $challenge->getAuthor());
        $this->userManager->removeFromStarted($challenge, $challenge->getChallenged());

        return;
    }

    private function remove(Challenge $challenge)
    {
        $this->em->remove($challenge);
        $this->em->flush();

        return;
    }

    public function generateChallengeForm()
    {
        $form = $this->formFactory->createBuilder(ChallengeType::class)->getForm()->createView();

        return $form;
    }

    public function generateReplyForm(Challenge $challenge)
    {
        $form = $this->formFactory->createBuilder(ChallengeReplyType::class)->getForm()->createView();

        return $form;
    }

    public function handleReplyForm(Challenge $challenge, Request $request)
    {
        $form = $this->formFactory->createBuilder(ChallengeReplyType::class, $challenge)->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($challenge);
            $this->em->flush();
        }

        $roundType = $challenge->getSecondRoundType()->getName();
        $round = $this->generateRound($roundType, $challenge);

        return $round;
    }

    public function handleChallengeForm(Request $request)
    {
        $challenge = new Challenge();
        $form = $this->formFactory->createBuilder(ChallengeType::class, $challenge)->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $challenge->setAuthor($this->tokenStorage->getToken()->getUser());
            $this->em->persist($challenge);
            $this->em->flush();
        }

        $roundType = $challenge->getFirstRoundType()->getName();
        $this->generateRound($roundType, $challenge);
        $this->userManager->startGame($challenge, $challenge->getAuthor());
        $this->userManager->startGame($challenge, $challenge->getChallenged());

        return $challenge;
    }

    public function generateRound($roundType, Challenge $challenge)
    {
        $language = $challenge->getLanguage();
        $grid = $this->gridManager->generate($language);
        switch ($roundType) {
            case 'rush':
                $round = $this->roundManager->generateRush($challenge, $grid);
                break;

            case 'conquer':
                $round = $this->roundManager->generateConquer($challenge, $grid);
                $this->objectiveManager->generateObjective($round);

                break;
        }

        return $round;
    }

    public function generateRandomRound(Challenge $challenge)
    {
        $types = $this->em->getRepository('MagicWordBundle:RoundType\RoundType')->findAll();
        shuffle($types);
        $round = $this->generateRound($types[0]->getName(), $challenge);

        return $round;
    }

    public function getNextURL(Challenge $challenge)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $round = $this->em->getRepository('MagicWordBundle:Round')->getNotPlayedYet($challenge, $user);

        if (!$round && count($challenge->getRounds()) === 2) {
            $round = $this->generateRandomRound($challenge);
        }

        if ($round) {
            $this->userManager->startGame($challenge);
            $url = $this->router->generate('round_play', ['id' => $round->getId()]);
        } else {
            $url = $this->router->generate('challenge_end', ['id' => $challenge->getId()]);
        }

        return $url;
    }
}
