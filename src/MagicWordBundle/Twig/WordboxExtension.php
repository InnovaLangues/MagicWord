<?php

namespace  MagicWordBundle\Twig;

use Innova\LexiconBundle\Entity\Lemma;

class WordboxExtension extends \Twig_Extension
{
    protected $em;
    protected $wordboxManager;

    public function __construct($entityManager, $wordboxManager)
    {
        $this->em = $entityManager;
        $this->wordboxManager = $wordboxManager;
    }

    public function isInWordbox(Lemma $lemma)
    {
        $inWordbox = $this->wordboxManager->isInWordbox($lemma);

        return $inWordbox;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('isInWordbox', array($this, 'isInWordbox')),
        );
    }

    public function getName()
    {
        return 'wordbox';
    }
}
