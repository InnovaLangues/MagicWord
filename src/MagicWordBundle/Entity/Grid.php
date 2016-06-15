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
     * @ORM\OneToMany(targetEntity="FoundableForm", mappedBy="grid")
     * @ORM\OrderBy({"points" = "DESC"})
     */
    private $foundableForms;

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
        foreach ($this->getFoundableForms() as $foundable) {
            $form = $foundable->getForm();
            $jsonArray['inflections'][$form] = array('ids' => [], 'lemmaIds' => []);

            foreach ($foundable->getInflections() as $inflection) {
                $jsonArray['inflections'][$form]['ids'][] = $inflection->getId();
                $lemmaId = $inflection->getLemma()->getId();
                if (!in_array($lemmaId, $jsonArray['inflections'][$form]['lemmaIds'])) {
                    $jsonArray['inflections'][$form]['lemmaIds'][] = $lemmaId;
                }
            }
        }

        return $jsonArray;
    }

    /**
     * Add foundableForm.
     *
     * @param \MagicWordBundle\Entity\FoundableForm $foundableForm
     *
     * @return Grid
     */
    public function addFoundableForm(\MagicWordBundle\Entity\FoundableForm $foundableForm)
    {
        $this->foundableForms[] = $foundableForm;

        return $this;
    }

    /**
     * Remove foundableForm.
     *
     * @param \MagicWordBundle\Entity\FoundableForm $foundableForm
     */
    public function removeFoundableForm(\MagicWordBundle\Entity\FoundableForm $foundableForm)
    {
        $this->foundableForms->removeElement($foundableForm);
    }

    /**
     * Get foundableForms.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFoundableForms()
    {
        return $this->foundableForms;
    }
}
