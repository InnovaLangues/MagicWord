<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\FoundableForm;
use MagicWordBundle\Entity\Grid;

/**
 * @DI\Service("mw_manager.foundableform")
 */
class FoundableFormManager
{
    protected $em;
    protected $scoreManager;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "scoreManager" = @DI\Inject("mw_manager.score")
     * })
     */
    public function __construct($entityManager, $scoreManager)
    {
        $this->em = $entityManager;
        $this->scoreManager = $scoreManager;
    }

    public function populateFoundables($inflections, Grid $grid)
    {
        $foundableForms = array();

        foreach ($inflections as $inflection) {
            if (!isset($foundableForms[$inflection->getCleanedContent()])) {
                $points = 0;
                $foundableForms[$inflection->getCleanedContent()] = array(
                    'inflections' => [$inflection],
                );
            } else {
                $foundableForms[$inflection->getCleanedContent()]['inflections'][] = $inflection;
            }
        }

        foreach ($foundableForms as $form => $foundableForm) {
            $foundable = new FoundableForm();
            $foundable->setGrid($grid);
            $foundable->setForm($form);
            $points = $this->scoreManager->getWordPoint($inflection, $grid->getLanguage());
            $foundable->setPoints($points);
            foreach ($foundableForm['inflections'] as $inflection) {
                $foundable->addInflection($inflection);
            }

            $this->em->persist($foundable);
        }

        $this->em->flush();

        return;
    }
}
