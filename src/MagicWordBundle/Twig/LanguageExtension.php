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
        $languages = $this->em->getRepository('MagicWordBundle:Language')->findAll();

        return $languages;
    }

    public function getFunctions()
    {
        return array(
            'get_languages' => new \Twig_Function_Method($this, 'getLanguages'),
        );
    }

    public function getName()
    {
        return 'get_languages';
    }
}
