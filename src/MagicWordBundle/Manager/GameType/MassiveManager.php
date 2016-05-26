<?php

namespace  MagicWordBundle\Manager\GameType;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\GameType\Massive;
use MagicWordBundle\Form\Type\MassiveType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @DI\Service("mw_manager.massive")
 */
class MassiveManager
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

    public function generateMassiveForm()
    {
        $form = $this->formFactory->createBuilder(MassiveType::class)->getForm()->createView();

        return $form;
    }

    public function handleMassiveForm(Request $request)
    {
        $massive = new Massive();
        $form = $this->formFactory->createBuilder(MassiveType::class, $massive)->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $massive->setAuthor($this->tokenStorage->getToken()->getUser());
            $this->em->persist($massive);
            $this->em->flush();
        }

        return $massive;
    }

    public function addRushRound($massive)
    {
        $grid = $this->gridManager->generate($massive->getLanguage());
        $this->roundManager->generateRush($massive, $grid);

        return;
    }
}
