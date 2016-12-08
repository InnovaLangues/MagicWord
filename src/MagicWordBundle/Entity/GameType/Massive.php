<?php

namespace MagicWordBundle\Entity\GameType;

use Doctrine\ORM\Mapping as ORM;
use MagicWordBundle\Entity\Game as Game;

/**
 * Massive.
 *
 * @ORM\Entity
 * @ORM\Table(name="game_type_massive")
 */
class Massive extends Game
{
    protected $discr = 'massive';

    /**
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = 0;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\AccessType")
     */
    private $accessType;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(name="publish_date", type="datetime", nullable=true)
     */
    private $publishDate;

    public function getDiscr()
    {
        return $this->discr;
    }

    /**
     * Set published.
     *
     * @param bool $published
     *
     * @return Massive
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published.
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set publishDate.
     *
     * @param \DateTime $publishDate
     *
     * @return Massive
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * Get publishDate.
     *
     * @return \DateTime
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set accessType.
     *
     * @param \MagicWordBundle\Entity\AccessType $accessType
     *
     * @return Massive
     */
    public function setAccessType(\MagicWordBundle\Entity\AccessType $accessType = null)
    {
        $this->accessType = $accessType;

        return $this;
    }

    /**
     * Get accessType.
     *
     * @return \MagicWordBundle\Entity\AccessType
     */
    public function getAccessType()
    {
        return $this->accessType;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Massive
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
