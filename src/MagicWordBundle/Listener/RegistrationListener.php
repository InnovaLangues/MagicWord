<?php

namespace MagicWordBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use FOS\UserBundle\Event\FormEvent;

class RegistrationListener
{
    private $wordboxManager;

    public function __construct($wordboxManager)
    {
        $this->wordboxManager = $wordboxManager;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onRegistration(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        $this->wordboxManager->createWordbox($user);
    }
}
