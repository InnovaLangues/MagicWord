<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Lexicon\Lemma;

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
    }

    public function addToWordbox(Lemma $lemma, $acquisitionType)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $wordbox = $user->getWordbox();
        $acquisitionType = $this->em->getRepository("MagicWordBundle:Wordbox\AcquisitionType")->findOneByValue($acquisitionType);
        if ($acquisition = $this->acquisitionManager->create($wordbox, $acquisitionType, $lemma)) {
            $wordbox->addAcquisition($acquisition);
        }

        return;
    }
}
