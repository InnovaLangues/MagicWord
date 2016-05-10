<?php

namespace MagicWordBundle\Entity\Letter;

use Doctrine\ORM\Mapping as ORM;

/**
 * Letter.
 *
 * @ORM\Entity
 * @ORM\Table(name="letter_letter")
 */
class Letter
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
     * @ORM\Column(name="value", type="string", length=2)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="CanonicLetter", inversedBy="letters")
     */
    protected $canonicLetter;

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
     * Set value.
     *
     * @param string $value
     *
     * @return Letter
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set canonicLetter.
     *
     * @param \MagicWordBundle\Entity\Letter\CanonicLetter $canonicLetter
     *
     * @return Letter
     */
    public function setCanonicLetter(\MagicWordBundle\Entity\Letter\CanonicLetter $canonicLetter = null)
    {
        $this->canonicLetter = $canonicLetter;

        return $this;
    }

    /**
     * Get canonicLetter.
     *
     * @return \MagicWordBundle\Entity\Letter\CanonicLetter
     */
    public function getCanonicLetter()
    {
        return $this->canonicLetter;
    }
}
