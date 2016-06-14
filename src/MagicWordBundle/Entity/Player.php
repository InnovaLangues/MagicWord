<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Table(name="player")
 * @ORM\Entity
 */
class Player extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="MagicWordBundle\Entity\Wordbox")
     */
    private $wordbox;

    /**
     * @ORM\ManyToMany(targetEntity="Player")
     * @ORM\JoinTable(name="players_friends",
     *      joinColumns={@ORM\JoinColumn(name="player_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_id", referencedColumnName="id")}
     *      )
     */
    private $friends;

    /**
     * @var bool
     *
     * @ORM\Column(name="hidden", type="boolean")
     */
    private $hidden = false;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="LanguageUI")
     */
    private $languageUI;

    /**
     * @ORM\ManyToMany(targetEntity="Game")
     * @ORM\JoinTable(name="player_startedgame")
     */
    private $startedGames;

    /**
     * @ORM\ManyToMany(targetEntity="Game")
     * @ORM\JoinTable(name="player_endedgame")
     */
    private $endedGames;

    /**
     * Set wordbox.
     *
     * @param \MagicWordBundle\Entity\Wordbox $wordbox
     *
     * @return Player
     */
    public function setWordbox(\MagicWordBundle\Entity\Wordbox $wordbox = null)
    {
        $this->wordbox = $wordbox;

        return $this;
    }

    /**
     * Get wordbox.
     *
     * @return \MagicWordBundle\Entity\Wordbox
     */
    public function getWordbox()
    {
        return $this->wordbox;
    }

    /**
     * Add friend.
     *
     * @param \MagicWordBundle\Entity\Player $friend
     *
     * @return Player
     */
    public function addFriend(\MagicWordBundle\Entity\Player $friend)
    {
        $this->friends[] = $friend;

        return $this;
    }

    /**
     * Remove friend.
     *
     * @param \MagicWordBundle\Entity\Player $friend
     */
    public function removeFriend(\MagicWordBundle\Entity\Player $friend)
    {
        $this->friends->removeElement($friend);
    }

    /**
     * Get friends.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * Set language.
     *
     * @param \MagicWordBundle\Entity\Language $language
     *
     * @return Game
     */
    public function setLanguage(\MagicWordBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return \MagicWordBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set hidden.
     *
     * @param bool $hidden
     *
     * @return Player
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden.
     *
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set languageUI.
     *
     * @param \MagicWordBundle\Entity\LanguageUI $languageUI
     *
     * @return Player
     */
    public function setLanguageUI(\MagicWordBundle\Entity\LanguageUI $languageUI = null)
    {
        $this->languageUI = $languageUI;

        return $this;
    }

    /**
     * Get languageUI.
     *
     * @return \MagicWordBundle\Entity\LanguageUI
     */
    public function getLanguageUI()
    {
        return $this->languageUI;
    }

    /**
     * Add startedGame
     *
     * @param \MagicWordBundle\Entity\Game $startedGame
     *
     * @return Player
     */
    public function addStartedGame(\MagicWordBundle\Entity\Game $startedGame)
    {
        $this->startedGames[] = $startedGame;

        return $this;
    }

    /**
     * Remove startedGame
     *
     * @param \MagicWordBundle\Entity\Game $startedGame
     */
    public function removeStartedGame(\MagicWordBundle\Entity\Game $startedGame)
    {
        $this->startedGames->removeElement($startedGame);
    }

    /**
     * Get startedGames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStartedGames()
    {
        return $this->startedGames;
    }

    /**
     * Add endedGame
     *
     * @param \MagicWordBundle\Entity\Game $endedGame
     *
     * @return Player
     */
    public function addEndedGame(\MagicWordBundle\Entity\Game $endedGame)
    {
        $this->endedGames[] = $endedGame;

        return $this;
    }

    /**
     * Remove endedGame
     *
     * @param \MagicWordBundle\Entity\Game $endedGame
     */
    public function removeEndedGame(\MagicWordBundle\Entity\Game $endedGame)
    {
        $this->endedGames->removeElement($endedGame);
    }

    /**
     * Get endedGames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEndedGames()
    {
        return $this->endedGames;
    }
}
