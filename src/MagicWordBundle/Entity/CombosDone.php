<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="combosdone")
 * @ORM\Entity()
 */
class CombosDone
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
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Rules\ComboPoints", cascade={"persist"})
     */
    private $comboType;

    /**
     * @var int
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total = 0;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Activity", inversedBy="combosDone")
     */
    private $activity;

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
     * Set total.
     *
     * @param int $total
     *
     * @return CombosDone
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set comboType.
     *
     * @param \MagicWordBundle\Entity\Rules\ComboPoints $comboType
     *
     * @return CombosDone
     */
    public function setComboType(\MagicWordBundle\Entity\Rules\ComboPoints $comboType = null)
    {
        $this->comboType = $comboType;

        return $this;
    }

    /**
     * Get comboType.
     *
     * @return \MagicWordBundle\Entity\Rules\ComboPoints
     */
    public function getComboType()
    {
        return $this->comboType;
    }

    /**
     * Set activity.
     *
     * @param \MagicWordBundle\Entity\Activity $activity
     *
     * @return CombosDone
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
}
