<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Lexicon\Inflection;
use MagicWordBundle\Entity\Language;

/**
 * @DI\Service("mw_manager.score")
 */
class ScoreManager
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

    public function getWordPoint(Inflection $inflection, Language $language)
    {
        $points = 0;
        $form = $inflection->getCleanedContent();

        $points += $this->getLengthPoints($form);
        $points += $this->getLettersPoints($form, $language);

        return $points;
    }

    public function getLengthPoints($form)
    {
        $repo = $this->em->getRepository("MagicWordBundle:Rules\WordLengthPoints");
        $wordLength = strlen($form);
        $points = ($wordLengthPoints = $repo->findOneBy(array('length' => $wordLength)))
            ? $wordLengthPoints->getPoints()
            : end($repo->findAll())->getPoints();

        return $points;
    }

    public function getLettersPoints($form, $language)
    {
        $points = 0;
        $letters = str_split($form);
        foreach ($letters as $letter) {
            $letterLanguage = $this->em->getRepository("MagicWordBundle:Letter\LetterLanguage")->findOneBy(['letter' => $letter, 'language' => $language]);
            $points += ($letterLanguage)
                ? $letterLanguage->getPoint()
                : 1;
        }

        return $points;
    }
}
