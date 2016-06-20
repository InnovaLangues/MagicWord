<?php

namespace MagicWordBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use FOS\UserBundle\Event\FormEvent;

class RegistrationListener
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onRegistration(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        $language = $this->entityManager->getRepository('MagicWordBundle:Language')->findOneByName('french');
        $user->setLanguage($language);
    }
}
