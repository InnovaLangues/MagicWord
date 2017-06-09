<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GridPattern.
 *
 * @ORM\Table(name="grid_pattern")
 * @ORM\Entity()
 */
class GridPattern
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $author;

    /**
    *  @ORM\OneToMany(targetEntity="MagicWordBundle\Entity\GridPatternString", mappedBy="gridPattern")
    */
    private $strings;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->strings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param \MagicWordBundle\Entity\Player $author
     *
     * @return GridPattern
     */
    public function setAuthor(\MagicWordBundle\Entity\Player $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \MagicWordBundle\Entity\Player
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add string
     *
     * @param \MagicWordBundle\Entity\GridPatternString $string
     *
     * @return GridPattern
     */
    public function addString(\MagicWordBundle\Entity\GridPatternString $string)
    {
        $this->strings[] = $string;

        return $this;
    }

    /**
     * Remove string
     *
     * @param \MagicWordBundle\Entity\GridPatternString $string
     */
    public function removeString(\MagicWordBundle\Entity\GridPatternString $string)
    {
        $this->strings->removeElement($string);
    }

    /**
     * Get strings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStrings()
    {
        return $this->strings;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return GridPattern
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return GridPattern
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
