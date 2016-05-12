<?php

namespace MagicWordBundle\Entity\Wordbox;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acquisition.
 *
 * @ORM\Table(name="wordbox_acquisition")
 * @ORM\Entity()
 */
class Acquisition
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
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Wordbox", inversedBy="acquisitions")
     * @ORM\JoinColumn(name="wordbox_id", referencedColumnName="id")
     */
    private $wordbox;

    /**
     * @ORM\ManyToOne(targetEntity="AcquisitionType")
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Lexicon\Inflection")
     */
    protected $inflection;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Acquisition
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set type.
     *
     * @param \MagicWordBundle\Entity\Wordbox\AcquisitionType $type
     *
     * @return Acquisition
     */
    public function setType(\MagicWordBundle\Entity\Wordbox\AcquisitionType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return \MagicWordBundle\Entity\Wordbox\AcquisitionType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set inflection.
     *
     * @param \MagicWordBundle\Entity\Lexicon\Inflection $inflection
     *
     * @return Acquisition
     */
    public function setInflection(\MagicWordBundle\Entity\Lexicon\Inflection $inflection = null)
    {
        $this->inflection = $inflection;

        return $this;
    }

    /**
     * Get inflection.
     *
     * @return \MagicWordBundle\Entity\Lexicon\Inflection
     */
    public function getInflection()
    {
        return $this->inflection;
    }

    /**
     * Set wordbox.
     *
     * @param \MagicWordBundle\Entity\Wordbox $wordbox
     *
     * @return Acquisition
     */
    public function setWordbox(\MagicWordBundle\Entity\Wordbox $wordbox = null)
    {
        $this->wordbox = $wordbox;

        return $this;
    }

    /**
     * Get wordbox.
     *
     * @return \MagicWordBundle\Entity\Wordbox
     */
    public function getWordbox()
    {
        return $this->wordbox;
    }
}
