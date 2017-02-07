<?php

namespace  MagicWordBundle\Twig;

class LanguageExtension extends \Twig_Extension
{
    protected $em;

    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    public function getLanguages()
    {
        $languages = $this->em->getRepository('InnovaLexiconBundle:Language')->findAll();

        return $languages;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('get_languages', array($this, 'getLanguages')),
        );
    }

    public function getName()
    {
        return 'get_languages';
    }
}
