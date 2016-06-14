<?php

namespace  MagicWordBundle\Twig;

use MagicWordBundle\Entity\Round;
use MagicWordBundle\Entity\Player;

class RoundActivityExtension extends \Twig_Extension
{
    protected $em;

    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    public function getActivity(Round $round, Player $player)
    {
        $activity = $this->em->getRepository('MagicWordBundle:Activity')->findOneBy(['round' => $round, 'player' => $player]);

        return $activity;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getActivity', array($this, 'getActivity')),
        );
    }

    public function getName()
    {
        return 'getActivity';
    }
}
