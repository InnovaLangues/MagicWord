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
     * @var bool
     *
     * @ORM\Column(name="forfeit", type="boolean")
     */
    private $forfeit;

    /**
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="score")
     */

    /**
     * @ORM\ManyToMany(targetEntity="Activity")
     * @ORM\JoinTable(name="score_activities",
     *      joinColumns={@ORM\JoinColumn(name="score_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="activity_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $activities;

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
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->activities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add activity.
     *
     * @param \MagicWordBundle\Entity\Activity $activity
     *
     * @return Score
     */
    public function addActivity(\MagicWordBundle\Entity\Activity $activity)
    {
        $this->activities[] = $activity;

        return $this;
    }

    /**
     * Remove activity.
     *
     * @param \MagicWordBundle\Entity\Activity $activity
     */
    public function removeActivity(\MagicWordBundle\Entity\Activity $activity)
    {
        $this->activities->removeElement($activity);
    }

    /**
     * Get activities.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * Set forfeit.
     *
     * @param bool $forfeit
     *
     * @return Score
     */
    public function setForfeit($forfeit)
    {
        $this->forfeit = $forfeit;

        return $this;
    }

    /**
     * Get forfeit.
     *
     * @return bool
     */
    public function getForfeit()
    {
        return $this->forfeit;
    }
}
