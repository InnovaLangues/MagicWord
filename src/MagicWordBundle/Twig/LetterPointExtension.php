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

    public function getFunctions()
    {
        return array(
            'get_point' => new \Twig_Function_Method($this, 'getPoint'),
        );
    }

    public function getName()
    {
        return 'get_point';
    }
}
