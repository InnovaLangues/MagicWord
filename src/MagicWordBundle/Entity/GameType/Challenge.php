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
}
