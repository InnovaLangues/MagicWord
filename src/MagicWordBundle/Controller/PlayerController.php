<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MagicWordBundle\Entity\Player as Player;

class PlayerController extends Controller
{
    /**
     * @Route("/friend/add/{id}")
     * @ParamConverter("player", class="MagicWordBundle:Player")
     */
    public function addFriendAction(Player $player)
    {
        return $this->render('MagicWordBundle:Default:index.html.twig');
    }

    /**
     * @Route("/friend/remove/{id}")
     * @ParamConverter("player", class="MagicWordBundle:Player")
     */
    public function removeFriendAction(Player $player)
    {
        return $this->render('MagicWordBundle:Default:index.html.twig');
    }
}
