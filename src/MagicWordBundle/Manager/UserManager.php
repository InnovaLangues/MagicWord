<?php

namespace  MagicWordBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use MagicWordBundle\Form\Type\PlayerType;
use MagicWordBundle\Form\Type\ProfileType;
use MagicWordBundle\Entity\Game;
use MagicWordBundle\Entity\GameType\Massive;
use Symfony\Component\HttpFoundation\Request;

/**
 * @DI\Service("mw_manager.user")
 */
class UserManager
{
    protected $em;
    protected $tokenStorage;
    protected $formFactory;
    protected $scoreManager;
    protected $session;
    protected $profilePicDir;

    /**
     * @DI\InjectParams({
     *      "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *      "tokenStorage"  = @DI\Inject("security.token_storage"),
     *      "formFactory"   = @DI\Inject("form.factory"),
     *      "scoreManager"  = @DI\Inject("mw_manager.score"),
     *      "session"       = @DI\Inject("session"),
     *      "profilePicDir" = @DI\Inject("%profilepic_directory%"),
     * })
     */
    public function __construct($entityManager, $tokenStorage, $formFactory, $scoreManager, $session, $profilePicDir)
    {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->formFactory = $formFactory;
        $this->scoreManager = $scoreManager;
        $this->session = $session;
        $this->profilePicDir = $profilePicDir;
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

    public function getProfileForm()
    {
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $form = $this->formFactory->createBuilder(ProfileType::class, $currentUser)->getForm();

        return $form;
    }

    public function handleProfileForm(Request $request)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $profilePic = $user->getProfilePicPath();
        $form = $this->formFactory->createBuilder(ProfileType::class, $user)->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->session->getFlashBag()->add('success', 'Profil modifié avec succès.');
                if ($file = $user->getProfilePicFile()) {
                    $profilePic = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->profilePicDir, $profilePic);
                }
                $user->setProfilePicPath($profilePic);
                $user->setProfilePicFile(null);
                $this->em->persist($user);
                $this->em->flush();
            } else {
                $this->session->getFlashBag()->add('warning', 'Erreur, profil non modifié.');
            }
        }

        return $form;
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

        $this->session->set('_locale', $currentUser->getLanguageUI()->getValue());

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

    public function startGame(Game $game, $user = null)
    {
        if (!$user) {
            $user = $this->tokenStorage->getToken()->getUser();
        }

        if (!$user->getStartedGames()->contains($game)) {
            $user->addStartedGame($game);
        }

        $this->em->persist($user);
        $this->em->flush();
    }

    public function endGame(Game $game, $forfeit = false)
    {
        $currentUser = $this->tokenStorage->getToken()->getUser();

        $this->scoreManager->calculateScore($game, $currentUser, $forfeit);
        $this->startToEndGame($game, $currentUser);

        return;
    }

    public function startToEndGame(Game $game, $user)
    {
        $this->removeFromStarted($game, $user);

        if (!$user->getEndedGames()->contains($game)) {
            $user->addEndedGame($game);
        }

        $this->em->persist($user);
        $this->em->flush();
    }

    public function removeFromStarted(Game $game, $user)
    {
        $user->removeStartedGame($game);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function canPlay($game)
    {
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $gameType = $game->getDiscr();

        if ($gameType != 'massive' && !$currentUser->getStartedGames()->contains($game)) {
            $this->session->getFlashBag()->add('warning', 'Hmmmm....');

            return false;
        }

        if ($gameType == 'massive' && $currentUser == $game->getAuthor()) {
            $this->session->getFlashBag()->add('warning', 'Vous ne pouvez pas jouer votre propre partie');

            return false;
        }

        return true;
    }

    public function isGranted(Massive $massive)
    {
        $currentUser = $this->tokenStorage->getToken()->getUser();
        if ($massive->getAuthor() !== $currentUser) {
            $this->session->getFlashBag()->add('warning', 'Seul le créateur de la partie a accès à cette page');

            return false;
        }

        return true;
    }
}
