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

    /**
     * @var int
     *
     * @ORM\Column(name="numberToFind", type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Lexicon\Category")
     */
    private $category;

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Constraint
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set category
     *
     * @param \MagicWordBundle\Entity\Lexicon\Category $category
     *
     * @return Constraint
     */
    public function setCategory(\MagicWordBundle\Entity\Lexicon\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \MagicWordBundle\Entity\Lexicon\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
