<?php

namespace MagicWordBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleListener implements EventSubscriberInterface
{
    private $defaultLocale;
    private $tokenStorage;

    public function __construct($defaultLocale = 'fr', $tokenStorage)
    {
        $this->defaultLocale = $defaultLocale;
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 100)),
        );
    }
}
