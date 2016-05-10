<?php

namespace MagicWordBundle\Entity\GameType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Game as Game;

/**
 * Challenge.
 *
 * @ORM\Table(name="game_type_challenge")
 */
class Challenge extends Game
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
