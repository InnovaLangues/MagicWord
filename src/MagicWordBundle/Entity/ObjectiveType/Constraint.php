<?php

namespace MagicWordBundle\Entity\ObjectiveType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Objective;

/**
 * Constraint.
 *
 * @ORM\Entity
 * @ORM\Table(name="objective_type_constraint")
 */
class Constraint extends Objective
{
    protected $discr = 'constraint';

    public function getDiscr()
    {
        return $this->discr;
    }
}
