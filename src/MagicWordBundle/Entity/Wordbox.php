<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wordbox.
 *
 * @ORM\Table(name="wordbox")
 * @ORM\Entity(repositoryClass="MagicWordBundle\Repository\WordboxRepository")
 */
class Wordbox
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
     * @ORM\OneToMany(targetEntity="MagicWordBundle\Entity\Wordbox\Acquisition", mappedBy="wordbox")
     */
    private $acquisitions;

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
     * Constructor.
     */
    public function __construct()
    {
        $this->acquisitions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add acquisition.
     *
     * @param \MagicWordBundle\Entity\Wordbox\Acquisition $acquisition
     *
     * @return Wordbox
     */
    public function addAcquisition(\MagicWordBundle\Entity\Wordbox\Acquisition $acquisition)
    {
        $this->acquisitions[] = $acquisition;

        return $this;
    }

    /**
     * Remove acquisition.
     *
     * @param \MagicWordBundle\Entity\Wordbox\Acquisition $acquisition
     */
    public function removeAcquisition(\MagicWordBundle\Entity\Wordbox\Acquisition $acquisition)
    {
        $this->acquisitions->removeElement($acquisition);
    }

    /**
     * Get acquisitions.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAcquisitions()
    {
        return $this->acquisitions;
    }
}
