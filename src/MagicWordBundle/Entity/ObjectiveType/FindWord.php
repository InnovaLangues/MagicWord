<?php

namespace MagicWordBundle\Entity\ObjectiveType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Objective;

/**
 * FindWord.
 *
 * @ORM\Table(name="objective_type_findword")
 * @ORM\Entity()
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
    protected $hint;

    /**
     * @var string
     *
     * @ORM\Column(name="inflection", type="text", nullable=false)
     */
    protected $inflection;

    /**
     * @ORM\ManyToMany(targetEntity="MagicWordBundle\Entity\Lexicon\Lemma")
     * @ORM\JoinTable(name="objective_findword_lemma")
     */
    private $lemmas;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $lemmaEnough;

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
     * Set lemmaEnough.
     *
     * @param bool $lemmaEnough
     *
     * @return FindWord
     */
    public function setLemmaEnough($lemmaEnough)
    {
        $this->lemmaEnough = $lemmaEnough;

        return $this;
    }

    /**
     * Get lemmaEnough.
     *
     * @return bool
     */
    public function getLemmaEnough()
    {
        return $this->lemmaEnough;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->lemmas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lemma.
     *
     * @param \MagicWordBundle\Entity\Lexicon\Lemma $lemma
     *
     * @return FindWord
     */
    public function addLemma(\MagicWordBundle\Entity\Lexicon\Lemma $lemma)
    {
        $this->lemmas[] = $lemma;

        return $this;
    }

    /**
     * Add lemmas.
     *
     * @param \MagicWordBundle\Entity\Lexicon\Lemma $lemma
     *
     * @return FindWord
     */
    public function addLemmas($lemmas)
    {
        foreach ($lemmas as $lemma) {
            $this->lemmas[] = $lemma;
        }

        return $this;
    }

    /**
     * Remove lemma.
     *
     * @param \MagicWordBundle\Entity\Lexicon\Lemma $lemma
     */
    public function removeLemma(\MagicWordBundle\Entity\Lexicon\Lemma $lemma)
    {
        $this->lemmas->removeElement($lemma);
    }

    /**
     * Get lemmas.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLemmas()
    {
        return $this->lemmas;
    }
}
