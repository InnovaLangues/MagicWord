<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activity.
 *
 * @ORM\Table(name="foundable_form")
 * @ORM\Entity()
 */
class FoundableForm
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
     * @ORM\Column(name="form", type="string", length=16)
     */
    private $form;

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @ORM\ManyToMany(targetEntity="MagicWordBundle\Entity\Lexicon\Inflection")
     * @ORM\JoinTable(name="inflections_foundable")
     */
    private $inflections;

    /**
     * @ORM\ManyToOne(targetEntity="Grid", inversedBy="foundableForms")
     */
    private $grid;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->inflections = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set form.
     *
     * @param string $form
     *
     * @return FoundableForm
     */
    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form.
     *
     * @return string
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set points.
     *
     * @param int $points
     *
     * @return FoundableForm
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
     * Add inflection.
     *
     * @param \MagicWordBundle\Entity\Lexicon\Inflection $inflection
     *
     * @return FoundableForm
     */
    public function addInflection(\MagicWordBundle\Entity\Lexicon\Inflection $inflection)
    {
        $this->inflections[] = $inflection;

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
     * Set grid.
     *
     * @param \MagicWordBundle\Entity\Grid $grid
     *
     * @return FoundableForm
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
}
