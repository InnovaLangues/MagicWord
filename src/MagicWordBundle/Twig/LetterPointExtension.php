<?php

namespace  MagicWordBundle\Twig;

class LetterPointExtension extends \Twig_Extension
{
    protected $em;

    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    public function getPoint($letter, $language)
    {
        $letterLanguage = $this->em->getRepository("MagicWordBundle:Letter\LetterLanguage")->findOneBy(['letter' => $letter, 'language' => $language]);

        $point = ($letterLanguage)
            ? $letterLanguage->getPoint()
            : 1;

        return $point;
    }

    public function getLetterPoints($language)
    {
        $letters = $this->em->getRepository("MagicWordBundle:Letter\LetterLanguage")->findByLanguage($language);

        $jsonArray = array();
        foreach ($letters as $letter) {
            $jsonArray[$letter->getLetter()->getValue()] = $letter->getPoint();
        }

        return $jsonArray;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('get_point', array($this, 'getPoint')),
            new \Twig_SimpleFunction('getLetterPoints', array($this, 'getLetterPoints')),
        );
    }

    public function getName()
    {
        return 'get_point';
    }
}
