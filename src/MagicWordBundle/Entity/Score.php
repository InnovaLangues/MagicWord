<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activity.
 *
 * @ORM\Table(name="score")
 * @ORM\Entity()
 */
class Score
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Game")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player;

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points = 0;

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
     * Set points.
     *
     * @param int $points
     *
     * @return Score
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points.
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set game.
     *
     * @param \MagicWordBundle\Entity\Game $game
     *
     * @return Score
     */
    public function setGame(\MagicWordBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game.
     *
     * @return \MagicWordBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set player.
     *
     * @param \MagicWordBundle\Entity\Player $player
     *
     * @return Score
     */
    public function setPlayer(\MagicWordBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player.
     *
     * @return \MagicWordBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }
}
