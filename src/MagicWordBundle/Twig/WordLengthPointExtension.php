<?php

namespace  MagicWordBundle\Twig;

class WordLengthPointExtension extends \Twig_Extension
{
    protected $em;

    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    public function getWordLengthPoints()
    {
        $points = $this->em->getRepository("MagicWordBundle:Rules\WordLengthPoints")->findAll();

        $jsonArray = array();
        foreach ($points as $point) {
            $jsonArray[$point->getLength()] = $point->getPoints();
        }

        return $jsonArray;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getWordLengthPoints', array($this, 'getWordLengthPoints')),
        );
    }

    public function getName()
    {
        return 'getWordLengthPoints';
    }
}
