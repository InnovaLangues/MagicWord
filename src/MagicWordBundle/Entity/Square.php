<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Square.
 *
 * @ORM\Table(name="square")
 * @ORM\Entity(repositoryClass="MagicWordBundle\Repository\SquareRepository")
 */
class Square
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
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Letter\CanonicLetter")
     */
    protected $letter;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="Grid", inversedBy="squares", cascade={"persist"})
     */
    protected $grid;

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
     * Set position.
     *
     * @param int $position
     *
     * @return Square
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set grid.
     *
     * @param \MagicWordBundle\Entity\Grid $grid
     *
     * @return Square
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
     * Set letter.
     *
     * @param \MagicWordBundle\Entity\Letter\CanonicLetter $letter
     *
     * @return Square
     */
    public function setLetter(\MagicWordBundle\Entity\Letter\CanonicLetter $letter = null)
    {
        $this->letter = $letter;

        return $this;
    }

    /**
     * Get letter.
     *
     * @return \MagicWordBundle\Entity\Letter\CanonicLetter
     */
    public function getLetter()
    {
        return $this->letter;
    }
}
