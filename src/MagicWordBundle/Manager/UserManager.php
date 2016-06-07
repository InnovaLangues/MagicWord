<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Form\Type\PlayerType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @DI\Service("mw_manager.user")
 */
class UserManager
{
    protected $em;
    protected $tokenStorage;
    protected $formFactory;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "tokenStorage" = @DI\Inject("security.token_storage"),
     *      "formFactory" = @DI\Inject("form.factory"),
     * })
     */
    public function __construct($entityManager, $tokenStorage, $formFactory)
    {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->formFactory = $formFactory;
    }

    public function getConnected($threshold)
    {
        $connectedUsers = array();
        $sessions = $this->em->getRepository('MagicWordBundle:PDOSession')->getLastSessions($threshold);
        foreach ($sessions as $session) {
            $data = stream_get_contents($session->getSessionValue());
            $data = str_replace('_sf2_attributes|', '', $data);
            $data = unserialize($data);

            // If this is a session belonging to an anonymous user, do nothing
            if (!array_key_exists('_security_main', $data)) {
                continue;
            }
            // Grab security data
            $data = $data['_security_main'];
            $data = unserialize($data);
            $username = $data->getUser()->getUsername();
            $user = $this->em->getRepository('MagicWordBundle:Player')->findOneByUsername($username);
            if (!in_array($user, $connectedUsers) && !$user->getHidden()) {
                $connectedUsers[] = $user;
            }
        }

        return $connectedUsers;
    }

    public function getParametersForm()
    {
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $form = $this->formFactory->createBuilder(PlayerType::class, $currentUser)->getForm();

        return $form;
    }

    public function handleParametersForm(Request $request)
    {
        $currentUser = $this->tokenStorage->getToken()->getUser();

        $form = $this->formFactory->createBuilder(PlayerType::class, $currentUser)->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($currentUser);
            $this->em->flush();
        }

        return $currentUser;
    }

    public function addFriend($friend)
    {
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $currentUser->addFriend($friend);
        $this->em->persist($currentUser);
        $this->em->flush();
    }

    public function removeFriend($friend)
    {
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $currentUser->removeFriend($friend);
        $this->em->persist($currentUser);
        $this->em->flush();
    }
}
