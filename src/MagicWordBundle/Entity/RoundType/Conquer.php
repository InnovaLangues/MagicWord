<?php

namespace MagicWordBundle\Entity\RoundType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Round as Round;

/**
 * Conquer.
 *
 * @ORM\Table(name="round_type_conquer")
 * @ORM\Entity
 */
class Conquer extends Round
{
    protected $discr = 'conquer';

    public function getDiscr()
    {
        return $this->discr;
    }
}
