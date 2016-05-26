<?php

namespace MagicWordBundle\Entity\GameType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Game as Game;

/**
 * Challenge.
 *
 * @ORM\Entity
 * @ORM\Table(name="game_type_challenge")
 */
class Challenge extends Game
{
    protected $discr = 'challenge';

    public function getDiscr()
    {
        return $this->discr;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Player")
     */
    protected $challenged;

    /**
     * Set message.
     *
     * @param string $message
     *
     * @return Challenge
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set challenged.
     *
     * @param \MagicWordBundle\Entity\Player $challenged
     *
     * @return Challenge
     */
    public function setChallenged(\MagicWordBundle\Entity\Player $challenged = null)
    {
        $this->challenged = $challenged;

        return $this;
    }

    /**
     * Get challenged.
     *
     * @return \MagicWordBundle\Entity\Player
     */
    public function getChallenged()
    {
        return $this->challenged;
    }
}
