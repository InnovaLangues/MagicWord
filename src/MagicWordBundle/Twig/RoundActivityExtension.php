<?php

namespace  MagicWordBundle\Twig;

use MagicWordBundle\Entity\Round;
use MagicWordBundle\Entity\Player;

class RoundActivityExtension extends \Twig_Extension
{
    protected $em;
    protected $timeManager;

    public function __construct($entityManager, $timeManager)
    {
        $this->em = $entityManager;
        $this->timeManager = $timeManager;
    }

    public function getActivity(Round $round, Player $player)
    {
        $activity = $this->em->getRepository('MagicWordBundle:Activity')->findOneBy(['round' => $round, 'player' => $player]);

        return $activity;
    }

    public function getActivities(Round $round)
    {
        $activities = $this->em->getRepository('MagicWordBundle:Activity')->findFinished($round);

        return $activities;
    }

    public function getTimeSpent($activity)
    {
        $delta = $this->timeManager->getDiff($activity->getStartDate(), $activity->getEndDate());

        return $delta;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getActivity', array($this, 'getActivity')),
            new \Twig_SimpleFunction('getActivities', array($this, 'getActivities')),
            new \Twig_SimpleFunction('getTimeSpent', array($this, 'getTimeSpent')),
        );
    }

    public function getName()
    {
        return 'getActivity';
    }
}
