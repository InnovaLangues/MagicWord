<?php

namespace MagicWordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use MagicWordBundle\Entity\Player;

class PlayerController extends Controller
{
    /**
     * @Route("/my-friends", name="my_friends")
     */
    public function displayFriendsAction()
    {
        return $this->render('MagicWordBundle:Player:friends.html.twig');
    }

    /**
     * @Route("/friend/add/{id}", name="add_friend")
     * @ParamConverter("friend", class="MagicWordBundle:Player")
     */
    public function addFriendAction(Player $friend)
    {
        $this->get('mw_manager.user')->addFriend($friend);

        return $this->redirectToRoute('profile', ['id' => $friend->getId()]);
    }

    /**
     * @Route("/friend/remove/{id}", name="remove_friend")
     * @ParamConverter("friend", class="MagicWordBundle:Player")
     */
    public function removeFriendAction(Player $friend)
    {
        $this->get('mw_manager.user')->removeFriend($friend);

        return $this->redirectToRoute('profile', ['id' => $friend->getId()]);
    }

    /**
     * @Route("/parameters", name="parameters")
     * @Method("GET")
     */
    public function getParametersAction()
    {
        $form = $this->get('mw_manager.user')->getParametersForm()->createView();

        return $this->render('MagicWordBundle:Player:parameters.html.twig', ['form' => $form]);
    }

    /**
     * @Route("/parameters")
     * @Method("POST")
     */
    public function setParametersAction(Request $request)
    {
        $this->get('mw_manager.user')->handleParametersForm($request);
        $this->get('session')->getFlashBag()->add('success', 'paramètres modifiés');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/user/{id}", name="profile")
     * @ParamConverter("player", class="MagicWordBundle:Player")
     */
    public function displayProfileAction(Player $player)
    {
        return $this->render('MagicWordBundle:Player:profile.html.twig', ['player' => $player]);
    }
}
