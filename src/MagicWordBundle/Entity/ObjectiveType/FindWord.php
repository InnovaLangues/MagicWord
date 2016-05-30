<?php

namespace MagicWordBundle\Entity\ObjectiveType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Objective;

/**
 * FindWord.
 *
 * @ORM\Entity
 * @ORM\Table(name="objective_type_findword")
 */
class FindWord extends Objective
{
    protected $discr = 'findword';

    public function getDiscr()
    {
        return $this->discr;
    }

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
     * Set inflection
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
     * Get inflection
     *
     * @return string
     */
    public function getInflection()
    {
        return $this->inflection;
    }
}
