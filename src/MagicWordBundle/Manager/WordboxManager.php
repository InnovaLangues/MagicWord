<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Lexicon\Lemma;
use MagicWordBundle\Entity\Wordbox;

/**
 * @DI\Service("mw_manager.wordbox")
 */
class WordboxManager
{
    protected $em;
    protected $tokenStorage;
    protected $acquisitionManager;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "tokenStorage" = @DI\Inject("security.token_storage"),
     *      "acquisitionManager" = @DI\Inject("mw_manager.acquisition"),
     * })
     */
    public function __construct($entityManager, $tokenStorage, $acquisitionManager)
    {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->acquisitionManager = $acquisitionManager;

        $this->checkWordbox();
    }

    public function getWordbox()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return $user->getWordbox();
    }

    public function addToWordbox(Lemma $lemma, $acquisitionType)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $acquisitionType = $this->em->getRepository("MagicWordBundle:Wordbox\AcquisitionType")->findOneByValue($acquisitionType);
        if ($acquisition = $this->acquisitionManager->create($wordbox, $acquisitionType, $lemma)) {
            $wordbox->addAcquisition($acquisition);
        }

        return;
    }

    public function checkWordbox()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if (!$user->getWordbox()) {
            $this->createWordbox($user);
        }
    }

    private function createWordbox($user)
    {
        $wordbox = new Wordbox();
        $user->setWordbox($wordbox);

        $this->em->persist($wordbox);
        $this->em->persist($user);
        $this->em->flush();

        return $wordbox;
    }
}
