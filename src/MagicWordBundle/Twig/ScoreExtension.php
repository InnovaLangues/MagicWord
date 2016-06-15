<?php

namespace MagicWordBundle\Twig;

class ScoreExtension extends \Twig_Extension
{
    protected $em;

    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    public function getScores($game)
    {
        $scores = $this->em->getRepository('MagicWordBundle:Score')->findBy(['game' => $game], ['points' => 'DESC']);

        return $scores;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getScores', array($this, 'getScores')),
        );
    }

    public function getName()
    {
        return 'getScores';
    }
}
