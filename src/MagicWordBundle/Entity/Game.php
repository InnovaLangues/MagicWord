<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game.
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="MagicWordBundle\Repository\GameRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"game"="Game", "massive"="MagicWordBundle\Entity\GameType\Massive", "challenge" = "MagicWordBundle\Entity\GameType\Challenge", "training"="MagicWordBundle\Entity\GameType\Training"})
 * @ORM\HasLifecycleCallbacks()
 */
class Game
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Round", mappedBy="game")
     * @ORM\OrderBy({"displayOrder" = "ASC"})
     */
    private $rounds;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\LexiconBundle\Entity\Language")
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Player")
     */
    private $author;

    /**
     * @ORM\Column(name="date", type="datetime", nullable=true)
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
     * Set name.
     *
     * @param string $name
     *
     * @return Game
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Game
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
     * Set language.
     *
     * @param \Innova\LexiconBundle\Entity\Language $language
     *
     * @return Game
     */
    public function setLanguage(\Innova\LexiconBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return \Innova\LexiconBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @ORM\PrePersist
     */
    public function updateDate()
    {
        $this->setDate(new \Datetime());
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Game
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
     * Set author.
     *
     * @param \MagicWordBundle\Entity\Player $author
     *
     * @return Game
     */
    public function setAuthor(\MagicWordBundle\Entity\Player $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return \MagicWordBundle\Entity\Player
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->rounds = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add round.
     *
     * @param \MagicWordBundle\Entity\Round $round
     *
     * @return Game
     */
    public function addRound(\MagicWordBundle\Entity\Round $round)
    {
        $this->rounds[] = $round;

        return $this;
    }

    /**
     * Remove round.
     *
     * @param \MagicWordBundle\Entity\Round $round
     */
    public function removeRound(\MagicWordBundle\Entity\Round $round)
    {
        $this->rounds->removeElement($round);
    }

    /**
     * Get rounds.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRounds()
    {
        return $this->rounds;
    }
}
