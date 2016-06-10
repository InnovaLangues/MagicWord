<?php

namespace  MagicWordBundle\Manager\GameType;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\GameType\Massive;
use MagicWordBundle\Entity\Round;
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

    public function play(Massive $massive)
    {
        $round = $this->em->getRepository('MagicWordBundle:Round')->find(180);

        return $round;
    }

    public function publish(Massive $massive)
    {
        $massive->setPublished(true);
        $this->em->persist($massive);
        $this->em->flush();

        return;
    }

    public function getMyMassives($published)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $massives = $this->em->getRepository('MagicWordBundle:GameType\Massive')->findBy(['author' => $user, 'published' => $published]);

        return $massives;
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

    public function addRushRound(Massive $massive)
    {
        $grid = $this->gridManager->generate($massive->getLanguage());
        $this->roundManager->generateRush($massive, $grid);

        return;
    }

    public function addConquerRound(Massive $massive)
    {
        $this->roundManager->generateConquer($massive);

        return;
    }

    public function removeRound(Massive $massive, Round $round)
    {
        $this->em->remove($round);
        $this->em->flush();

        $this->reorderRounds($massive);

        return;
    }

    private function reorderRounds(Massive $massive)
    {
        $rounds = $massive->getRounds();
        $i = 0;
        foreach ($rounds as $round) {
            $round->setDisplayOrder($i);
            $this->em->persist($round);
            ++$i;
        }
        $this->em->flush();

        return;
    }
}
