<?php

namespace MagicWordBundle\Controller\RoundType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\RoundType\Rush;

class RushController extends Controller
{
    /**
     * @Route("/rush/{id}", name="rush")
     * @ParamConverter("rush", class="MagicWordBundle:RoundType\Rush")
     */
    public function displayRushAction(Rush $rush)
    {
        return $this->render('MagicWordBundle:Round/Rush:edit.html.twig', ['rush' => $rush]);
    }
}
