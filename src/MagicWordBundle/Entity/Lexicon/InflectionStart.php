<?php

namespace MagicWordBundle\Entity\Lexicon;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Table(name="inflection_start", indexes={
 *  @Index(columns={"start"}, flags={"fulltext"}),
 *  @Index(name="language_id", columns={"language"}),
 * })
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
     * Set language.
     *
     * @param int $language
     *
     * @return InflectionStart
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return int
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
