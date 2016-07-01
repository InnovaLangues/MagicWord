<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Score;
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

    public function getWordPoint($form, $letterPoints)
    {
        $points = 0;

        $points += $this->getLengthPoints($form);
        $points += $this->getLettersPoints($form, $letterPoints);

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

    public function getLettersPoints($form, $letterPoints)
    {
        $points = 0;
        $letters = str_split($form);
        foreach ($letters as $letter) {
            $points += (array_key_exists($letter, $letterPoints)) ? $letterPoints[$letter] : 1;
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
                $points += $activity->getComboPoints();
                break;
            case 'conquer':
                $points += $this->getPointForObjectives($activity);
                break;
        }

        return floor($points);
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

        $points += round(300 / $objectivesDoableCount) * $objectiveDoneCount;

        if ($objectiveDoneCount === $objectivesDoableCount) {
            $timePoints = floor((1 / $activity->getDuration()) * 3000);
            $activity->setTimePoints($timePoints);
            $this->em->persist($activity);
            $this->em->flush();

            $points += $timePoints;
        }

        return $points;
    }

    public function calculateScore($game, $user)
    {
        if (!$this->em->getRepository('MagicWordBundle:Score')->findOneBy(['game' => $game, 'player' => $user])) {
            $points = 0;
            $activities = [];
            $rounds = $game->getRounds();

            $score = new Score();
            foreach ($rounds as $round) {
                $activity = $this->em->getRepository('MagicWordBundle:Activity')->findOneBy(['round' => $round, 'player' => $user]);
                $score->addActivity($activity);
                $points += $activity->getPoints();
            }

            $score->setGame($game);
            $score->setPoints($points);
            $score->setPlayer($user);
            $this->em->persist($score);
            $this->em->flush();
        }

        return;
    }

    public function getLettersPointsArray($language)
    {
        $letters = $this->em->getRepository("MagicWordBundle:Letter\LetterLanguage")->findByLanguage($language);

        $letterPoints = array();
        foreach ($letters as $letter) {
            $letterPoints[$letter->getLetter()->getValue()] = $letter->getPoint();
        }

        return $letterPoints;
    }
}
