<?php

namespace MagicWordBundle\Entity\GameType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Game as Game;

/**
 * Massive.
 *
 * @ORM\Entity
 * @ORM\Table(name="game_type_massive")
 */
class Massive extends Game
{
    protected $discr = 'massive';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime", nullable=true)
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;

    /**
     * Set start.
     *
     * @param \DateTime $start
     *
     * @return Massive
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start.
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end.
     *
     * @param \DateTime $end
     *
     * @return Massive
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end.
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    public function getDiscr()
    {
        return $this->discr;
    }
}
