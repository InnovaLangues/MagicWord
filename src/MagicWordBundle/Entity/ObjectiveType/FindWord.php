<?php

namespace MagicWordBundle\Entity\ObjectiveType;

use Doctrine\ORM\Mapping as ORM;

/**
 * FindWord.
 *
 * @ORM\Entity
 * @ORM\Table(name="objective_type_findword")
 */
class FindWord
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    protected $discr = 'findword';

    public function getDiscr()
    {
        return $this->discr;
    }

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Round", inversedBy="findWords")
     */
    private $round;

    /**
     * @var string
     *
     * @ORM\Column(name="hint", type="text", nullable=false)
     */
    private $hint;

    /**
     * @var string
     *
     * @ORM\Column(name="inflection", type="text", nullable=false)
     */
    private $inflection;

    /**
     * Set hint.
     *
     * @param string $hint
     *
     * @return FindWord
     */
    public function setHint($hint)
    {
        $this->hint = $hint;

        return $this;
    }

    /**
     * Get hint.
     *
     * @return string
     */
    public function getHint()
    {
        return $this->hint;
    }

    /**
     * Set inflection.
     *
     * @param string $inflection
     *
     * @return FindWord
     */
    public function setInflection($inflection)
    {
        $this->inflection = $inflection;

        return $this;
    }

    /**
     * Get inflection.
     *
     * @return string
     */
    public function getInflection()
    {
        return $this->inflection;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set round
     *
     * @param \MagicWordBundle\Entity\Round $round
     *
     * @return FindWord
     */
    public function setRound(\MagicWordBundle\Entity\Round $round = null)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get round
     *
     * @return \MagicWordBundle\Entity\Round
     */
    public function getRound()
    {
        return $this->round;
    }
}
