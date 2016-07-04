<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game.
 *
 * @ORM\Table(name="objective")
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"objective"="Objective", "findword"="MagicWordBundle\Entity\ObjectiveType\FindWord", "combo"="MagicWordBundle\Entity\ObjectiveType\Combo", "constraint"="MagicWordBundle\Entity\ObjectiveType\Constraint"})
 * @ORM\HasLifecycleCallbacks()
 */
class Objective implements \JsonSerializable
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\RoundType\Conquer", inversedBy="objectives")
     */
    private $conquer;

    /**
     * Set conquer.
     *
     * @param \MagicWordBundle\Entity\RoundType\Conquer $conquer
     *
     * @return Objective
     */
    public function setConquer(\MagicWordBundle\Entity\RoundType\Conquer $conquer = null)
    {
        $this->conquer = $conquer;

        return $this;
    }

    /**
     * Get conquer.
     *
     * @return \MagicWordBundle\Entity\RoundType\Conquer
     */
    public function getConquer()
    {
        return $this->conquer;
    }

    public function jsonSerialize()
    {
        $jsonArray = [
            'id' => $this->id,
            'type' => $this->getDiscr(),
            'content' => [],
        ];

        if ($this->getDiscr() == 'findword') {
            $jsonArray['content']['inflection'] = $this->inflection;
        }

        return $jsonArray;
    }
}
