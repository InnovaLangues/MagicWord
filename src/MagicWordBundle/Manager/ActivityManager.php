<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Round;
use MagicWordBundle\Entity\Activity;
use MagicWordBundle\Entity\Objective;
use MagicWordBundle\Entity\FoundableForm;

/**
 * @DI\Service("mw_manager.activity")
 */
class ActivityManager
{
    protected $em;
    protected $tokenStorage;
    protected $scoreManager;
    protected $userManager;
    protected $timeManager;
    protected $currentUser;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "tokenStorage" = @DI\Inject("security.token_storage"),
     *      "scoreManager" = @DI\Inject("mw_manager.score"),
     *      "userManager" = @DI\Inject("mw_manager.user"),
     *      "timeManager" = @DI\Inject("mw_manager.time"),
     * })
     */
    public function __construct($entityManager, $tokenStorage, $scoreManager, $userManager, $timeManager)
    {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->scoreManager = $scoreManager;
        $this->userManager = $userManager;
        $this->timeManager = $timeManager;
        $this->currentUser = $this->tokenStorage->getToken()->getUser();
    }

    public function init(Round $round)
    {
        $activityInfo = [];
        $activity = $this->getActivity($round);
        if (!$activity) {
            $this->create($round);
            $activityInfo['delta'] = 0;
        } else {
            $activityInfo['delta'] = $this->timeManager->getDiffInSeconds($activity->getStartDate(), new \DateTime());
            $activityInfo['infos'] = $activity;
        }

        return $activityInfo;
    }

    public function addFoundForm(Round $round, FoundableForm $foundableform)
    {
        $activity = $this->getActivity($round);

        $activity->addFoundForm($foundableform);
        $this->em->persist($activity);
        $this->em->flush();
    }

    public function addObjectiveDone(Round $round, Objective $objective)
    {
        $activity = $this->getActivity($round);

        $activity->addObjectivesDone($objective);
        $this->em->persist($activity);
        $this->em->flush();
    }

    private function create(Round $round)
    {
        $activity = new Activity();
        $activity->setRound($round);
        $activity->setPlayer($this->currentUser);
        $activity->setStartDate(new \DateTime());

        $this->em->persist($activity);
        $this->em->flush();

        return $activity;
    }

    public function endActivity(Round $round)
    {
        $activity = $this->getActivity($round);
        if (!$activity->getEndDate()) {
            $activity->setEndDate(new \DateTime());
            $activity->setDuration($this->timeManager->getDiffInSeconds($activity->getStartDate(), $activity->getEndDate()));
            $points = $this->scoreManager->countActivityPoints($activity);
            $activity->setPoints($points);

            $this->em->persist($activity);
            $this->em->flush();

            $game = $round->getGame();
            if ($game->getDiscr() == 'training') {
                $this->userManager->endGame($game);
            }
        }

        return $activity;
    }

    public function getActivity(Round $round)
    {
        return $activity = $this->em->getRepository('MagicWordBundle:Activity')->findOneBy(['player' => $this->currentUser, 'round' => $round]);
    }
}
