<?php

namespace MagicWordBundle\Entity\RoundType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Round as Round;

/**
 * Rush.
 *
 * @ORM\Table(name="round_type_rush")
 * @ORM\Entity
 */
class Rush extends Round
{
    protected $discr = 'rush';

    public function getDiscr()
    {
        return $this->discr;
    }
}
