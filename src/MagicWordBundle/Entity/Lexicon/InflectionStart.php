<?php

namespace MagicWordBundle\Entity\Lexicon;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="inflection_start")
 * @ORM\Entity(repositoryClass="MagicWordBundle\Repository\Lexicon\InflectionStartRepository")
 */
class InflectionStart
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
     * @var int
     *
     * @ORM\Column(name="language", type="integer")
     */
    private $language = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="start", type="string", length=255)
     */
    private $start;

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
     * Set start.
     *
     * @param string $start
     *
     * @return InflectionStart
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start.
     *
     * @return string
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set language
     *
     * @param integer $language
     *
     * @return InflectionStart
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return integer
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
