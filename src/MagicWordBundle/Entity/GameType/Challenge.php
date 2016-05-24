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
    protected $challenger;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Player")
     */
    protected $challenged;
}
