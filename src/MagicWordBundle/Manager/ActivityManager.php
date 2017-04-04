<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Entity\Round;
use MagicWordBundle\Entity\Activity;
use MagicWordBundle\Entity\Objective;
use MagicWordBundle\Entity\FoundableForm;
use MagicWordBundle\Entity\Rules\ComboPoints;

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
    protected $wrongFormManager;
    protected $comboManager;
    protected $currentUser;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "tokenStorage" = @DI\Inject("security.token_storage"),
     *      "scoreManager" = @DI\Inject("mw_manager.score"),
     *      "userManager" = @DI\Inject("mw_manager.user"),
     *      "timeManager" = @DI\Inject("mw_manager.time"),
     *      "wrongFormManager" = @DI\Inject("mw_manager.wrongform"),
     *      "comboManager" = @DI\Inject("mw_manager.combo"),
     * })
     */
    public function __construct($entityManager, $tokenStorage, $scoreManager, $userManager, $timeManager, $wrongFormManager, $comboManager)
    {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->scoreManager = $scoreManager;
        $this->userManager = $userManager;
        $this->timeManager = $timeManager;
        $this->wrongFormManager = $wrongFormManager;
        $this->comboManager = $comboManager;
        $this->currentUser = $this->tokenStorage->getToken()->getUser();
    }

    public function init(Round $round)
    {
        $activityInfo = [];
        $activity = $this->getActivity($round);
        if (!$activity) {
            $this->create($round);
            $activityInfo['delta'] = 0;
            $activityInfo['combopoints'] = 0;
        } else {
            $activityInfo['delta'] = $this->timeManager->getDiffInSeconds($activity->getStartDate(), new \DateTime());
            $activityInfo['infos'] = $activity;
            $activityInfo['combopoints'] = $activity->getComboPoints();
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

    public function addWrongForm(Round $round, $form)
    {
        $activity = $this->getActivity($round);
        $language = $round->getLanguage();

        $wrongForm = $this->em->getRepository('MagicWordBundle:WrongForm')->findOneBy([
            'language' => $language,
            'form' => $form,
        ]);

        if (!$wrongForm) {
            $wrongForm = $this->wrongFormManager->create($form, $language);
        }

        $activity->addWrongForm($wrongForm);
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

    public function addComboPoints(Round $round, ComboPoints $comboPoints)
    {
        $activity = $this->getActivity($round);

        $activity->setComboPoints($activity->getComboPoints() + $comboPoints->getPoints());
        $this->em->persist($activity);
        $this->em->flush();
    }

    public function saveComboFinished(Round $round, ComboPoints $comboPoints)
    {
        $activity = $this->getActivity($round);
        $comboDone = ($comboDone = $this->em->getRepository('MagicWordBundle:CombosDone')->findOneBy(['activity' => $activity, 'comboType' => $comboPoints]))
            ? $comboDone
            : $this->comboManager->create($comboPoints, $activity);

        $comboDone = $this->comboManager->increment($comboDone);

        $this->em->persist($comboDone);
        $this->em->flush();

        return;
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
        return $this->em->getRepository('MagicWordBundle:Activity')->findOneBy(['player' => $this->currentUser, 'round' => $round]);
    }

    public function canAccessScores(Activity $activity)
    {
        $currentUserActivity = $this->getActivity($activity->getRound());
        $gameAuthor = $activity->getRound()->getGame()->getAuthor();

        return ($this->currentUser === $gameAuthor || $currentUserActivity->getEndDate())
            ? true
            : false;
    }
}
