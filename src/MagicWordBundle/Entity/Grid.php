<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grid.
 *
 * @ORM\Table(name="grid")
 * @ORM\Entity(repositoryClass="MagicWordBundle\Repository\GridRepository")
 */
class Grid implements \JsonSerializable
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
     * @var int
     *
     * @ORM\Column(name="height", type="integer")
     */
    private $height = 4;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="integer")
     */
    private $width = 4;

    /**
     * @ORM\ManyToMany(targetEntity="MagicWordBundle\Entity\Lexicon\Inflection", inversedBy="grids")
     * @ORM\JoinTable(name="inflections_grids")
     */
    private $inflections;

    /**
     * @ORM\OneToMany(targetEntity="Square", mappedBy="grid")
     */
    protected $squares;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $language;

    public function __construct()
    {
        $this->inflections = new \Doctrine\Common\Collections\ArrayCollection();
        $this->squares = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set height.
     *
     * @param int $height
     *
     * @return Grid
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set width.
     *
     * @param int $width
     *
     * @return Grid
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Add square.
     *
     * @param \MagicWordBundle\Entity\Square $square
     *
     * @return Grid
     */
    public function addSquare(\MagicWordBundle\Entity\Square $square)
    {
        $this->squares[] = $square;

        return $this;
    }

    /**
     * Remove square.
     *
     * @param \MagicWordBundle\Entity\Square $square
     */
    public function removeSquare(\MagicWordBundle\Entity\Square $square)
    {
        $this->squares->removeElement($square);
    }

    /**
     * Get squares.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSquares()
    {
        return $this->squares;
    }

    /**
     * Add inflection.
     *
     * @param \MagicWordBundle\Entity\Lexicon\Inflection $inflection
     *
     * @return Grid
     */
    public function addInflection(\MagicWordBundle\Entity\Lexicon\Inflection $inflection)
    {
        $this->inflections[] = $inflection;

        return $this;
    }

    public function addInflections($inflections)
    {
        foreach ($inflections as $inflection) {
            $this->addInflection($inflection);
        }

        return $this;
    }

    /**
     * Remove inflection.
     *
     * @param \MagicWordBundle\Entity\Lexicon\Inflection $inflection
     */
    public function removeInflection(\MagicWordBundle\Entity\Lexicon\Inflection $inflection)
    {
        $this->inflections->removeElement($inflection);
    }

    /**
     * Get inflections.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInflections()
    {
        return $this->inflections;
    }

    /**
     * Set language.
     *
     * @param \MagicWordBundle\Entity\Language $language
     *
     * @return Game
     */
    public function setLanguage(\MagicWordBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return \MagicWordBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function jsonSerialize()
    {
        $jsonArray = array(
            'id' => $this->id,
            'inflections' => array(),
        );

        foreach ($this->getInflections() as $inflection) {
            if (!isset($jsonArray['inflections'][$inflection->getCleanedContent()])) {
                $jsonArray['inflections'][$inflection->getCleanedContent()] = array(
                    'ids' => [$inflection->getId()],
                    'lemmaIds' => [$inflection->getLemma()->getId()],
                );
            } else {
                $jsonArray['inflections'][$inflection->getCleanedContent()]['ids'][] = $inflection->getId();
                $lemmaId = $inflection->getLemma()->getId();
                if (!in_array($lemmaId, $jsonArray['inflections'][$inflection->getCleanedContent()]['lemmaIds'])) {
                    $jsonArray['inflections'][$inflection->getCleanedContent()]['lemmaIds'][] = $inflection->getLemma()->getId();
                }
            }
        }

        return $jsonArray;
    }
}
