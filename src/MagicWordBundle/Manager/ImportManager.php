<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Round;
use MagicWordBundle\Entity\GameType\Massive;

/**
 * @DI\Service("mw_manager.import")
 */
class ImportManager
{
    protected $em;
    protected $gridManager;
    protected $objectiveManager;
    protected $roundManager;
    protected $tokenStorage;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "gridManager"   = @DI\Inject("mw_manager.grid"),
     *      "objectiveManager"   = @DI\Inject("mw_manager.objective"),
     *      "roundManager"   = @DI\Inject("mw_manager.round"),
     *      "tokenStorage"  = @DI\Inject("security.token_storage"),
     * })
     */
    public function __construct($entityManager, $gridManager, $objectiveManager, $roundManager, $tokenStorage)
    {
        $this->em = $entityManager;
        $this->gridManager = $gridManager;
        $this->objectiveManager = $objectiveManager;
        $this->roundManager = $roundManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function importGame($gameJSON)
    {
        $name = $gameJSON['name'];
        $description = $gameJSON['description'];
        $language = $this->em->getRepository('InnovaLexiconBundle:Language')->findOneById($gameJSON['language']);
        $accessType = $this->em->getRepository('MagicWordBundle:AccessType')->findOneById($gameJSON['access']);

        $massive = new Massive();
        $massive->setAuthor($this->tokenStorage->getToken()->getUser());
        $massive->setName($name.' (import)');
        $massive->setDescription($description);
        $massive->setLanguage($language);
        $massive->setAccessType($accessType);
        $this->em->persist($massive);
        $this->em->flush();

        $rounds = $gameJSON['rounds'];
        foreach ($rounds as $round) {
            $this->importRound($round, $massive);
        }

        return $massive->getId();
    }

    public function importRound($roundJSON, Massive $massive)
    {
        $letters = $roundJSON['grid']['letters'];
        $language = $this->em->getRepository('InnovaLexiconBundle:Language')->findOneById($roundJSON['language']);
        $grid = $letters ? $this->gridManager->generate($language, $letters) : null;

        $displayOrder = $roundJSON['displayOrder'];
        $type = $roundJSON['type'];
        $round = ($type == 'rush')
            ? $this->roundManager->generateRush($massive, $grid, $language, $displayOrder)
            : $this->roundManager->generateConquer($massive, $grid, $language, $displayOrder);

        if ($type == 'conquer') {
            $objectives = $roundJSON['objectives'];
            foreach ($objectives as $objective) {
                $this->importObjective($objective, $round);
            }
        }
        $round->setTitle($roundJSON['title']);
        $round->setDescription($roundJSON['description']);

        $this->em->persist($round);
        $this->em->flush();

        return;
    }

    public function importObjective($objectiveJSON, Round $round)
    {
        switch ($objectiveJSON['type']) {
            case 'findword':
                $lemmaEnough = $objectiveJSON['lemmaEnough'];
                $form = $objectiveJSON['inflection'];
                $hint = $objectiveJSON['hint'];
                $this->objectiveManager->generateFindWord($lemmaEnough, $form, $hint, $round);

                break;

            case 'combo':
                $length = $objectiveJSON['length'];
                $number = $objectiveJSON['number'];

                $this->objectiveManager->generateCombo($number, $length, $round);
                break;

            case 'constraint':
                $properties = [];
                $properties['numberToFind'] = $objectiveJSON['numberToFind'];

                $properties['category'] = ($objectiveJSON['category'])
                    ? $this->em->getRepository('InnovaLexiconBundle:Category')->findOneById($objectiveJSON['category'])
                    : null;

                $properties['gender'] = ($objectiveJSON['gender'])
                    ? $this->em->getRepository('InnovaLexiconBundle:Gender')->findOneById($objectiveJSON['gender'])
                    : null;

                $properties['tense'] = ($objectiveJSON['tense'])
                    ? $this->em->getRepository('InnovaLexiconBundle:Tense')->findOneById($objectiveJSON['tense'])
                    : null;

                $properties['person'] = ($objectiveJSON['person'])
                    ? $this->em->getRepository('InnovaLexiconBundle:Person')->findOneById($objectiveJSON['person'])
                    : null;

                $properties['mood'] = ($objectiveJSON['mood'])
                    ? $this->em->getRepository('InnovaLexiconBundle:Mood')->findOneById($objectiveJSON['mood'])
                    : null;

                $properties['number'] = ($objectiveJSON['number'])
                    ? $this->em->getRepository('InnovaLexiconBundle:Number')->findOneById($objectiveJSON['number'])
                    : null;

                $this->objectiveManager->generateConstraint($round, $properties);

                break;
        }

        return;
    }
}
