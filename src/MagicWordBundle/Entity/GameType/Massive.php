<?php

namespace MagicWordBundle\Entity\GameType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Game as Game;

/**
 * Massive.
 *
 * @ORM\Entity
 * @ORM\Table(name="game_type_massive")
 */
class Massive extends Game
{
    protected $discr = 'massive';

    public function getDiscr()
    {
        return $this->discr;
    }
}
