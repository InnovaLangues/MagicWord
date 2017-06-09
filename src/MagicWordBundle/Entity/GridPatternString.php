<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GridPatternString.
 *
 * @ORM\Table(name="grid_pattern_string")
 * @ORM\Entity()
 */
class GridPatternString
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
     * @ORM\Column(name="value", type="string", length=16)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\GridPattern", inversedBy="strings")
     */
    private $gridPattern;

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
     * Set gridPattern
     *
     * @param \MagicWordBundle\Entity\GridPattern $gridPattern
     *
     * @return GridPatternString
     */
    public function setGridPattern(\MagicWordBundle\Entity\GridPattern $gridPattern = null)
    {
        $this->gridPattern = $gridPattern;

        return $this;
    }

    /**
     * Get gridPattern
     *
     * @return \MagicWordBundle\Entity\GridPattern
     */
    public function getGridPattern()
    {
        return $this->gridPattern;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return GridPatternString
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
