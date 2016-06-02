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
class Round implements \JsonSerializable
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
     * @ORM\OneToMany(targetEntity="MagicWordBundle\Entity\ObjectiveType\Combo", mappedBy="round", cascade={"persist"})
     */
    private $combos;

    /**
     * @ORM\OneToMany(targetEntity="MagicWordBundle\Entity\ObjectiveType\FindWord", mappedBy="round", cascade={"persist"})
     */
    private $findWords;

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

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->combos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->findWords = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add combo.
     *
     * @param \MagicWordBundle\Entity\ObjectiveType\Combo $combo
     *
     * @return Round
     */
    public function addCombo(\MagicWordBundle\Entity\ObjectiveType\Combo $combo)
    {
        $this->combos[] = $combo;

        return $this;
    }

    /**
     * Remove combo.
     *
     * @param \MagicWordBundle\Entity\ObjectiveType\Combo $combo
     */
    public function removeCombo(\MagicWordBundle\Entity\ObjectiveType\Combo $combo)
    {
        $this->combos->removeElement($combo);
    }

    /**
     * Get combos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCombos()
    {
        return $this->combos;
    }

    /**
     * Add findWord.
     *
     * @param \MagicWordBundle\Entity\ObjectiveType\FindWord $findWord
     *
     * @return Round
     */
    public function addFindWord(\MagicWordBundle\Entity\ObjectiveType\FindWord $findWord)
    {
        $this->findWords[] = $findWord;

        return $this;
    }

    /**
     * Remove findWord.
     *
     * @param \MagicWordBundle\Entity\ObjectiveType\FindWord $findWord
     */
    public function removeFindWord(\MagicWordBundle\Entity\ObjectiveType\FindWord $findWord)
    {
        $this->findWords->removeElement($findWord);
    }

    /**
     * Get findWords.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFindWords()
    {
        return $this->findWords;
    }

    public function getObjectives()
    {
        $objectives = array();
        $objectives[] = $this->findWords;
        $objectives[] = $this->combos;

        return $objectives;
    }

    public function jsonSerialize()
    {
        $jsonArray = array(
            'findWords' => array(),
            'combos' => array(),
            'type' => $this->discr,
        );

        foreach ($this->getFindWords() as $findWord) {
            $jsonArray['findWords'][$findWord->getInflection()] = array('id' => $findWord->getId());
        }

        foreach ($this->getCombos() as $combo) {
            $jsonArray['combos'][] =
                [
                    'id' => $combo->getId(),
                    'lenght' => $combo->getLenght(),
                    'number' => $combo->getNumber(),
                ];
        }

        return $jsonArray;
    }
}
