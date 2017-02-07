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
     * @ORM\ManyToOne(targetEntity="Innova\LexiconBundle\Entity\Category")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\LexiconBundle\Entity\Gender")
     */
    private $gender;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\LexiconBundle\Entity\Tense")
     */
    private $tense;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\LexiconBundle\Entity\Person")
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\LexiconBundle\Entity\Mood")
     */
    private $mood;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\LexiconBundle\Entity\Number")
     */
    private $number;

    /**
     * Set category.
     *
     * @param \Innova\LexiconBundle\Entity\Category $category
     *
     * @return Constraint
     */
    public function setCategory(\Innova\LexiconBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return \Innova\LexiconBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set numberToFind.
     *
     * @param int $numberToFind
     *
     * @return Constraint
     */
    public function setNumberToFind($numberToFind)
    {
        $this->numberToFind = $numberToFind;

        return $this;
    }

    /**
     * Get numberToFind.
     *
     * @return int
     */
    public function getNumberToFind()
    {
        return $this->numberToFind;
    }

    /**
     * Set gender.
     *
     * @param \Innova\LexiconBundle\Entity\Gender $gender
     *
     * @return Constraint
     */
    public function setGender(\Innova\LexiconBundle\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return \Innova\LexiconBundle\Entity\Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set tense.
     *
     * @param \Innova\LexiconBundle\Entity\Tense $tense
     *
     * @return Constraint
     */
    public function setTense(\Innova\LexiconBundle\Entity\Tense $tense = null)
    {
        $this->tense = $tense;

        return $this;
    }

    /**
     * Get tense.
     *
     * @return \Innova\LexiconBundle\Entity\Tense
     */
    public function getTense()
    {
        return $this->tense;
    }

    /**
     * Set person.
     *
     * @param \Innova\LexiconBundle\Entity\Person $person
     *
     * @return Constraint
     */
    public function setPerson(\Innova\LexiconBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person.
     *
     * @return \Innova\LexiconBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set mood.
     *
     * @param \Innova\LexiconBundle\Entity\Mood $mood
     *
     * @return Constraint
     */
    public function setMood(\Innova\LexiconBundle\Entity\Mood $mood = null)
    {
        $this->mood = $mood;

        return $this;
    }

    /**
     * Get mood.
     *
     * @return \Innova\LexiconBundle\Entity\Mood
     */
    public function getMood()
    {
        return $this->mood;
    }

    /**
     * Set number.
     *
     * @param \Innova\LexiconBundle\Entity\Number $number
     *
     * @return Constraint
     */
    public function setNumber(\Innova\LexiconBundle\Entity\Number $number = null)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return \Innova\LexiconBundle\Entity\Number
     */
    public function getNumber()
    {
        return $this->number;
    }
}
