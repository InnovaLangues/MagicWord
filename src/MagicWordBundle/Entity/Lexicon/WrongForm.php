<?php

namespace MagicWordBundle\Entity\Lexicon;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity(repositoryClass="MagicWordBundle\Repository\Lexicon\WrongFormRepository")
 * @ORM\Table(name="wrongform", indexes={
 *  @Index(name="wrongform", columns={"form"}),
 * })
 */
class WrongForm
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
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Language")
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="form", type="string", length=20)
     */
    private $form;

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
     * Set language.
     *
     * @param \MagicWordBundle\Entity\Language $language
     *
     * @return Game
     */
    public function setLanguage(\MagicWordBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return \MagicWordBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set form.
     *
     * @param string $form
     *
     * @return WrongForm
     */
    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form.
     *
     * @return string
     */
    public function getForm()
    {
        return $this->form;
    }
}
