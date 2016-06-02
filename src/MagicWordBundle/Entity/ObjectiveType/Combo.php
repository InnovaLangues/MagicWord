<?php

namespace MagicWordBundle\Entity\ObjectiveType;

use Doctrine\ORM\Mapping as ORM;

/**
 * Combo.
 *
 * @ORM\Entity
 * @ORM\Table(name="objective_type_combo")
 */
class Combo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    protected $discr = 'combo';

    public function getDiscr()
    {
        return $this->discr;
    }

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Round", inversedBy="combos")
     */
    private $round;

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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set round.
     *
     * @param \MagicWordBundle\Entity\Round $round
     *
     * @return Combo
     */
    public function setRound(\MagicWordBundle\Entity\Round $round = null)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get round.
     *
     * @return \MagicWordBundle\Entity\Round
     */
    public function getRound()
    {
        return $this->round;
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
