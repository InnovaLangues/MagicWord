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
    private $numberToFind;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Lexicon\Category")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Lexicon\Gender")
     */
    private $gender;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Lexicon\Tense")
     */
    private $tense;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Lexicon\Person")
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Lexicon\Mood")
     */
    private $mood;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Lexicon\Number")
     */
    private $number;

    /**
     * Set category.
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
     * Get category.
     *
     * @return \MagicWordBundle\Entity\Lexicon\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set numberToFind
     *
     * @param integer $numberToFind
     *
     * @return Constraint
     */
    public function setNumberToFind($numberToFind)
    {
        $this->numberToFind = $numberToFind;

        return $this;
    }

    /**
     * Get numberToFind
     *
     * @return integer
     */
    public function getNumberToFind()
    {
        return $this->numberToFind;
    }

    /**
     * Set gender
     *
     * @param \MagicWordBundle\Entity\Lexicon\Gender $gender
     *
     * @return Constraint
     */
    public function setGender(\MagicWordBundle\Entity\Lexicon\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \MagicWordBundle\Entity\Lexicon\Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set tense
     *
     * @param \MagicWordBundle\Entity\Lexicon\Tense $tense
     *
     * @return Constraint
     */
    public function setTense(\MagicWordBundle\Entity\Lexicon\Tense $tense = null)
    {
        $this->tense = $tense;

        return $this;
    }

    /**
     * Get tense
     *
     * @return \MagicWordBundle\Entity\Lexicon\Tense
     */
    public function getTense()
    {
        return $this->tense;
    }

    /**
     * Set person
     *
     * @param \MagicWordBundle\Entity\Lexicon\Person $person
     *
     * @return Constraint
     */
    public function setPerson(\MagicWordBundle\Entity\Lexicon\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \MagicWordBundle\Entity\Lexicon\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set mood
     *
     * @param \MagicWordBundle\Entity\Lexicon\Mood $mood
     *
     * @return Constraint
     */
    public function setMood(\MagicWordBundle\Entity\Lexicon\Mood $mood = null)
    {
        $this->mood = $mood;

        return $this;
    }

    /**
     * Get mood
     *
     * @return \MagicWordBundle\Entity\Lexicon\Mood
     */
    public function getMood()
    {
        return $this->mood;
    }

    /**
     * Set number
     *
     * @param \MagicWordBundle\Entity\Lexicon\Number $number
     *
     * @return Constraint
     */
    public function setNumber(\MagicWordBundle\Entity\Lexicon\Number $number = null)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return \MagicWordBundle\Entity\Lexicon\Number
     */
    public function getNumber()
    {
        return $this->number;
    }
}
