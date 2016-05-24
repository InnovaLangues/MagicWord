<?php

namespace MagicWordBundle\Entity\GameType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Game as Game;

/**
 * Training.
 *
 * @ORM\Entity
 * @ORM\Table(name="game_type_training")
 */
class Training extends Game
{
    protected $discr = 'training';

    public function getDiscr()
    {
        return $this->discr;
    }
}
