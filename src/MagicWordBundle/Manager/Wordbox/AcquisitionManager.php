<?php

namespace  MagicWordBundle\Manager\Wordbox;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Wordbox;
use MagicWordBundle\Entity\Lexicon\Lemma;
use MagicWordBundle\Entity\Wordbox\Acquisition;
use MagicWordBundle\Entity\Wordbox\AcquisitionType;

/**
 * @DI\Service("mw_manager.acquisition")
 */
class AcquisitionManager
{
    protected $em;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     * })
     */
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    public function create(Wordbox $wordbox, AcquisitionType $acquisitionType, Lemma $lemma)
    {
        if (!$this->em->getRepository("MagicWordBundle:Wordbox\Acquisition")->findOneBy(array('wordbox' => $wordbox, 'lemma' => $lemma))) {
            $acquisition = new Acquisition();
            $acquisition->setWordbox($wordbox);
            $acquisition->setType($acquisitionType);
            $acquisition->setLemma($lemma);
            $acquisition->setDate(new \DateTime());

            $this->em->persist($acquisition);
            $this->em->flush();

            return $acquisition;
        }

        return;
    }
}
