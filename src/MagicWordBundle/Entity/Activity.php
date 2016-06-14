<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activity.
 *
 * @ORM\Table(name="activity")
 * @ORM\Entity()
 */
class Activity
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
     * @ORM\ManyToOne(targetEntity="Round", cascade={"remove"})
     * @ORM\JoinColumn(name="round_id", referencedColumnName="id",  onDelete="CASCADE")
     */
    private $round;

    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player;

    /**
     * @ORM\ManyToMany(targetEntity="FoundableForm")
     * @ORM\JoinTable(name="activity_foundForm")
     */
    private $foundForms;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime", nullable=true)
     */
    private $endDate;

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
     * Set startDate.
     *
     * @param \DateTime $startDate
     *
     * @return Activity
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate.
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set round.
     *
     * @param \MagicWordBundle\Entity\Round $round
     *
     * @return Activity
     */
    public function setRound(\MagicWordBundle\Entity\Round $round = null)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get round.
     *
     * @return \MagicWordBundle\Entity\Round
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * Set player.
     *
     * @param \MagicWordBundle\Entity\Player $player
     *
     * @return Activity
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
     * Set foundForms.
     *
     * @param \MagicWordBundle\Entity\FoundableForm $foundForms
     *
     * @return Activity
     */
    public function setFoundForms(\MagicWordBundle\Entity\FoundableForm $foundForms = null)
    {
        $this->foundForms = $foundForms;

        return $this;
    }

    /**
     * Get foundForms.
     *
     * @return \MagicWordBundle\Entity\FoundableForm
     */
    public function getFoundForms()
    {
        return $this->foundForms;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->foundForms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add foundForm.
     *
     * @param \MagicWordBundle\Entity\FoundableForm $foundForm
     *
     * @return Activity
     */
    public function addFoundForm(\MagicWordBundle\Entity\FoundableForm $foundForm)
    {
        $this->foundForms[] = $foundForm;

        return $this;
    }

    /**
     * Remove foundForm.
     *
     * @param \MagicWordBundle\Entity\FoundableForm $foundForm
     */
    public function removeFoundForm(\MagicWordBundle\Entity\FoundableForm $foundForm)
    {
        $this->foundForms->removeElement($foundForm);
    }

    /**
     * Set endDate.
     *
     * @param \DateTime $endDate
     *
     * @return Activity
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set points.
     *
     * @param int $points
     *
     * @return Activity
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
