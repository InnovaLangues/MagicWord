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
     * Add friend
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
     * Remove friend
     *
     * @param \MagicWordBundle\Entity\Player $friend
     */
    public function removeFriend(\MagicWordBundle\Entity\Player $friend)
    {
        $this->friends->removeElement($friend);
    }

    /**
     * Get friends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriends()
    {
        return $this->friends;
    }
}
