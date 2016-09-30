<?php

namespace MagicWordBundle\Twig;

class GameExtension extends \Twig_Extension
{
    protected $em;

    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    public function getActivityCount($game)
    {
        $activityCount = $this->em->getRepository('MagicWordBundle:Player')->countByGame($game);

        return $activityCount;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getActivityCount', array($this, 'getActivityCount')),
        );
    }

    public function getName()
    {
        return 'getActivityCount';
    }
}
