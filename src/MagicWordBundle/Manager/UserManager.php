<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("mw_manager.user")
 */
class UserManager
{
    protected $em;
    protected $tokenStorage;
    protected $acquisitionManager;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "tokenStorage" = @DI\Inject("security.token_storage"),
     *      "acquisitionManager" = @DI\Inject("mw_manager.acquisition"),
     * })
     */
    public function __construct($entityManager, $tokenStorage, $acquisitionManager)
    {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->acquisitionManager = $acquisitionManager;
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
            if (!in_array($user, $connectedUsers)) {
                $connectedUsers[] = $user;
            }
        }

        return $connectedUsers;
    }
}
