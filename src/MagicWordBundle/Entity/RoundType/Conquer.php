<?php

namespace MagicWordBundle\Entity\RoundType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Round as Round;

/**
 * Conquer.
 *
 * @ORM\Table(name="round_type_conquer")
 * @ORM\Entity
 */
class Conquer extends Round
{
    protected $discr = 'conquer';

    public function getDiscr()
    {
        return $this->discr;
    }

    /**
     * @ORM\OneToMany(targetEntity="MagicWordBundle\Entity\Objective", mappedBy="conquer", cascade={"persist"})
     */
    private $objectives;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->objectives = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add objective.
     *
     * @param \MagicWordBundle\Entity\Objective $objective
     *
     * @return Conquer
     */
    public function addObjective(\MagicWordBundle\Entity\Objective $objective)
    {
        $this->objectives[] = $objective;

        return $this;
    }

    /**
     * Remove objective.
     *
     * @param \MagicWordBundle\Entity\Objective $objective
     */
    public function removeObjective(\MagicWordBundle\Entity\Objective $objective)
    {
        $this->objectives->removeElement($objective);
    }

    /**
     * Get objectives.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjectives()
    {
        return $this->objectives;
    }
}
