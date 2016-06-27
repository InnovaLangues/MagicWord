<?php

namespace MagicWordBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use FOS\UserBundle\Event\FormEvent;

class RegistrationListener
{
    private $entityManager;
    private $wordboxManager;

    public function __construct($entityManager, $wordboxManager)
    {
        $this->entityManager = $entityManager;
        $this->wordboxManager = $wordboxManager;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onRegistration(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        $language = $this->entityManager->getRepository('MagicWordBundle:Language')->findOneByName('french');
        $user->setLanguage($language);

        $user = $this->tokenStorage->getToken()->getUser();

        $this->wordboxManager->createWordbox($user);
    }
}
