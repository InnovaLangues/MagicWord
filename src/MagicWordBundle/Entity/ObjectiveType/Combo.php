<?php

namespace MagicWordBundle\Entity\ObjectiveType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Objective;

/**
 * Combo.
 *
 * @ORM\Entity
 * @ORM\Table(name="objective_type_combo")
 */
class Combo extends Objective
{
    protected $discr = 'combo';

    public function getDiscr()
    {
        return $this->discr;
    }
}
