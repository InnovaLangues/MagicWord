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

    /**
     * @var int
     *
     * @ORM\Column(name="lenght", type="integer")
     */
    private $lenght;

    /**
     * @var int
     *
     * @ORM\Column(name="numberToFind", type="integer")
     */
    private $number;

    /**
     * Set number.
     *
     * @param int $number
     *
     * @return Combo
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set lenght.
     *
     * @param int $lenght
     *
     * @return Combo
     */
    public function setLenght($lenght)
    {
        $this->lenght = $lenght;

        return $this;
    }

    /**
     * Get lenght.
     *
     * @return int
     */
    public function getLenght()
    {
        return $this->lenght;
    }
}
