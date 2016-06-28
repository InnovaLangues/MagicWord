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
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\RoundType\RoundType")
     */
    protected $firstRoundType;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\RoundType\RoundType")
     */
    protected $secondRoundType;

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

    /**
     * Set firstRoundType.
     *
     * @param \MagicWordBundle\Entity\RoundType\RoundType $firstRoundType
     *
     * @return Challenge
     */
    public function setFirstRoundType(\MagicWordBundle\Entity\RoundType\RoundType $firstRoundType = null)
    {
        $this->firstRoundType = $firstRoundType;

        return $this;
    }

    /**
     * Get firstRoundType.
     *
     * @return \MagicWordBundle\Entity\RoundType\RoundType
     */
    public function getFirstRoundType()
    {
        return $this->firstRoundType;
    }

    /**
     * Set secondRoundType.
     *
     * @param \MagicWordBundle\Entity\RoundType\RoundType $secondRoundType
     *
     * @return Challenge
     */
    public function setSecondRoundType(\MagicWordBundle\Entity\RoundType\RoundType $secondRoundType = null)
    {
        $this->secondRoundType = $secondRoundType;

        return $this;
    }

    /**
     * Get secondRoundType.
     *
     * @return \MagicWordBundle\Entity\RoundType\RoundType
     */
    public function getSecondRoundType()
    {
        return $this->secondRoundType;
    }
}
