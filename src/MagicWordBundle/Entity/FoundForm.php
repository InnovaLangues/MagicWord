<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Found Form.
 *
 * @ORM\Table(name="found_form")
 * @ORM\Entity()
 */
class FoundForm
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
     * @ORM\ManyToOne(targetEntity="Activity", inversedBy="foundForms")
     */
    private $activity;

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
     * @ORM\JoinTable(name="inflections_found")
     */
    private $inflections;

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
     * @return FoundForm
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
     * Set activity.
     *
     * @param \MagicWordBundle\Entity\Activity $activity
     *
     * @return FoundForm
     */
    public function setActivity(\MagicWordBundle\Entity\Activity $activity = null)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity.
     *
     * @return \MagicWordBundle\Entity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Add inflection.
     *
     * @param \MagicWordBundle\Entity\Lexicon\Inflection $inflection
     *
     * @return FoundForm
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
     * Set points.
     *
     * @param int $points
     *
     * @return FoundForm
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
}
