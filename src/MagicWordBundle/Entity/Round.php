<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Round.
 *
 * @ORM\Table(name="round")
 * @ORM\Entity(repositoryClass="MagicWordBundle\Repository\RoundRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"round"="Round", "rush"="MagicWordBundle\Entity\RoundType\Rush", "conquer" = "MagicWordBundle\Entity\RoundType\Conquer"})
 */
class Round
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="fixedGrid", type="boolean")
     */
    private $fixedGrid = 1;

    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="rounds", cascade={"persist"})
     */
    private $game;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $displayOrder;

    /**
     * @ORM\ManyToOne(targetEntity="Grid")
     */
    private $grid;

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
     * Set title.
     *
     * @param string $title
     *
     * @return Round
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Round
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set fixedGrid.
     *
     * @param bool $fixedGrid
     *
     * @return Round
     */
    public function setFixedGrid($fixedGrid)
    {
        $this->fixedGrid = $fixedGrid;

        return $this;
    }

    /**
     * Get fixedGrid.
     *
     * @return bool
     */
    public function getFixedGrid()
    {
        return $this->fixedGrid;
    }

    /**
     * Set game.
     *
     * @param \MagicWordBundle\Entity\Game $game
     *
     * @return Round
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
     * Set grid.
     *
     * @param \MagicWordBundle\Entity\Grid $grid
     *
     * @return Round
     */
    public function setGrid(\MagicWordBundle\Entity\Grid $grid = null)
    {
        $this->grid = $grid;

        return $this;
    }

    /**
     * Get grid.
     *
     * @return \MagicWordBundle\Entity\Grid
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * Set displayOrder.
     *
     * @param int $displayOrder
     *
     * @return Round
     */
    public function setDisplayOrder($displayOrder)
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    /**
     * Get displayOrder.
     *
     * @return int
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }
}
