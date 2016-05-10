<?php

namespace MagicWordBundle\Entity\Letter;

use Doctrine\ORM\Mapping as ORM;

/**
 * CanonicLetter.
 *
 * @ORM\Entity
 * @ORM\Table(name="letter_canonic_letter")
 */
class CanonicLetter
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
     * @ORM\Column(name="value", type="string", length=1, unique=true)
     */
    private $value;

    /**
     * @ORM\OneToMany(targetEntity="Letter", mappedBy="canonicLetter")
     */
    protected $letters;

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
     * @return CanonicLetter
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
     * Constructor.
     */
    public function __construct()
    {
        $this->letters = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add letter.
     *
     * @param \MagicWordBundle\Entity\Letter\Letter $letter
     *
     * @return CanonicLetter
     */
    public function addLetter(\MagicWordBundle\Entity\Letter\Letter $letter)
    {
        $this->letters[] = $letter;

        return $this;
    }

    /**
     * Remove letter.
     *
     * @param \MagicWordBundle\Entity\Letter\Letter $letter
     */
    public function removeLetter(\MagicWordBundle\Entity\Letter\Letter $letter)
    {
        $this->letters->removeElement($letter);
    }

    /**
     * Get letters.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLetters()
    {
        return $this->letters;
    }
}
