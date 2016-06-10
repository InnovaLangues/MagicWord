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
     * @ORM\ManyToOne(targetEntity="Round")
     */
    private $round;

    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player;

    /**
     * @ORM\OneToMany(targetEntity="FoundForm", mappedBy="activity", cascade={"remove"})
     */
    private $foundForms;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->foundForms = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add foundForm.
     *
     * @param \MagicWordBundle\Entity\FoundForm $foundForm
     *
     * @return Activity
     */
    public function addFoundForm(\MagicWordBundle\Entity\FoundForm $foundForm)
    {
        $this->foundForms[] = $foundForm;

        return $this;
    }

    /**
     * Remove foundForm.
     *
     * @param \MagicWordBundle\Entity\FoundForm $foundForm
     */
    public function removeFoundForm(\MagicWordBundle\Entity\FoundForm $foundForm)
    {
        $this->foundForms->removeElement($foundForm);
    }

    /**
     * Get foundForms.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFoundForms()
    {
        return $this->foundForms;
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
}
