<?php

namespace  MagicWordBundle\Manager\GameType;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\GameType\Challenge;
use MagicWordBundle\Form\Type\ChallengeType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @DI\Service("mw_manager.challenge")
 */
class ChallengeManager
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

    public function generateChallengeForm()
    {
        $form = $this->formFactory->createBuilder(ChallengeType::class)->getForm()->createView();

        return $form;
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

        return $challenge;
    }
}
