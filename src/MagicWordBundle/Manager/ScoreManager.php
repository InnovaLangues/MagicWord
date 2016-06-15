<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Lexicon\Inflection;
use MagicWordBundle\Entity\Score;
use MagicWordBundle\Entity\Language;
use MagicWordBundle\Entity\Activity;

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

    public function countActivityPoints(Activity $activity)
    {
        $points = 0;
        $round = $activity->getRound();
        $discr = $round->getDiscr();

        switch ($discr) {
            case 'rush':
                $points += $this->getPointForFoundables($activity->getFoundForms());
                break;
            case 'conquer':
                $points += $this->getPointForObjectives($activity);
                break;
        }

        return $points;
    }

    private function getPointForFoundables($foundForms)
    {
        $points = 0;
        foreach ($foundForms as $foundForm) {
            $points += $foundForm->getPoints();
        }

        return $points;
    }

    private function getPointForObjectives(Activity $activity)
    {
        $points = 0;
        $round = $activity->getRound();

        $objectiveDoneCount = count($activity->getObjectivesDone());
        $objectivesDoableCount = count($round->getObjectives());

        return $points;
    }

    public function calculateScore($game, $user)
    {
        $points = 0;
        $rounds = $game->getRounds();
        foreach ($rounds as $round) {
            $activity = $this->em->getRepository('MagicWordBundle:Activity')->findOneBy(['round' => $round, 'player' => $user]);
            $points += $activity->getPoints();
        }

        if (!$this->em->getRepository('MagicWordBundle:Score')->findOneBy(['game' => $game, 'player' => $user])) {
            $score = new Score();
            $score->setGame($game);
            $score->setPoints($points);
            $score->setPlayer($user);

            $this->em->persist($score);
            $this->em->flush();
        }

        return;
    }
}
