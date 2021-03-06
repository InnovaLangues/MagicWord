<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="general_parameters")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="MagicWordBundle\Repository\GeneralParametersRepository")
 */
class GeneralParameters
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="selfregistration", type="boolean")
     */
    private $selfRegistration = true;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $homeText;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $footer;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $piwikUrl;

    /**
     * @ORM\OneToOne(targetEntity="Game")
     */
    private $tutorial;

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
     * Set selfRegistration
     *
     * @param boolean $selfRegistration
     *
     * @return GeneralParameters
     */
    public function setSelfRegistration($selfRegistration)
    {
        $this->selfRegistration = $selfRegistration;

        return $this;
    }

    /**
     * Get selfRegistration
     *
     * @return boolean
     */
    public function getSelfRegistration()
    {
        return $this->selfRegistration;
    }

    /**
     * Set homeText
     *
     * @param string $homeText
     *
     * @return GeneralParameters
     */
    public function setHomeText($homeText)
    {
        $this->homeText = $homeText;

        return $this;
    }

    /**
     * Get homeText
     *
     * @return string
     */
    public function getHomeText()
    {
        return $this->homeText;
    }

    /**
     * Set game.
     *
     * @param \MagicWordBundle\Entity\Game $game
     *
     * @return Tutorial
     */
    public function setTutorial(\MagicWordBundle\Entity\Game $tutorial = null)
    {
        $this->tutorial = $tutorial;

        return $this;
    }

    /**
     * Get game.
     *
     * @return \MagicWordBundle\Entity\Game
     */
    public function getTutorial()
    {
        return $this->tutorial;
    }

    /**
     * Set piwikUrl
     *
     * @param string $piwikUrl
     *
     * @return GeneralParameters
     */
    public function setPiwikUrl($piwikUrl)
    {
        $this->piwikUrl = $piwikUrl;

        return $this;
    }

    /**
     * Get piwikUrl
     *
     * @return string
     */
    public function getPiwikUrl()
    {
        return $this->piwikUrl;
    }

    /**
     * Set footer
     *
     * @param string $footer
     *
     * @return GeneralParameters
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * Get footer
     *
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }
}
