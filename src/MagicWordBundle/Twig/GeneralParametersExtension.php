<?php

namespace  MagicWordBundle\Twig;

use MagicWordBundle\Entity\Round;
use MagicWordBundle\Entity\Player;

class GeneralParametersExtension extends \Twig_Extension
{
    protected $administrationManager;

    public function __construct($administrationManager)
    {
        $this->administrationManager = $administrationManager;
    }

    public function getGeneralParameters()
    {
        $generalParameters = $this->administrationManager->getGeneralParameters();

        return $generalParameters;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getGeneralParameters', array($this, 'getGeneralParameters')),
        );
    }

    public function getName()
    {
        return 'generalParameters';
    }
}
