<?php

namespace MagicWordBundle\Entity\Lexicon;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lemma.
 *
 * @ORM\Table(name="lemma")
 * @ORM\Entity()
 */
class Lemma
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
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Lexicon\Category")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Lexicon\Subcategory")
     */
    private $subcategory;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Lexicon\Gender")
     */
    private $gender;

    /**
     * @var bool
     *
     * @ORM\Column(name="locution", type="boolean", length=255)
     */
    private $locution;

    /**
     * @var bool
     *
     * @ORM\Column(name="processStatus", type="boolean", length=255)
     */
    private $processStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="phonetic1", type="string", length=255)
     */
    private $phonetic1;

    /**
     * @var string
     *
     * @ORM\Column(name="phonetic2", type="string", length=255)
     */
    private $phonetic2;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

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
     * Set content
     *
     * @param string $content
     *
     * @return Lemma
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set locution
     *
     * @param boolean $locution
     *
     * @return Lemma
     */
    public function setLocution($locution)
    {
        $this->locution = $locution;

        return $this;
    }

    /**
     * Get locution
     *
     * @return boolean
     */
    public function getLocution()
    {
        return $this->locution;
    }

    /**
     * Set processStatus
     *
     * @param boolean $processStatus
     *
     * @return Lemma
     */
    public function setProcessStatus($processStatus)
    {
        $this->processStatus = $processStatus;

        return $this;
    }

    /**
     * Get processStatus
     *
     * @return boolean
     */
    public function getProcessStatus()
    {
        return $this->processStatus;
    }

    /**
     * Set phonetic1
     *
     * @param string $phonetic1
     *
     * @return Lemma
     */
    public function setPhonetic1($phonetic1)
    {
        $this->phonetic1 = $phonetic1;

        return $this;
    }

    /**
     * Get phonetic1
     *
     * @return string
     */
    public function getPhonetic1()
    {
        return $this->phonetic1;
    }

    /**
     * Set phonetic2
     *
     * @param string $phonetic2
     *
     * @return Lemma
     */
    public function setPhonetic2($phonetic2)
    {
        $this->phonetic2 = $phonetic2;

        return $this;
    }

    /**
     * Get phonetic2
     *
     * @return string
     */
    public function getPhonetic2()
    {
        return $this->phonetic2;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Lemma
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set category
     *
     * @param \MagicWordBundle\Entity\Lexicon\Category $category
     *
     * @return Lemma
     */
    public function setCategory(\MagicWordBundle\Entity\Lexicon\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \MagicWordBundle\Entity\Lexicon\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set subcategory
     *
     * @param \MagicWordBundle\Entity\Lexicon\Subcategory $subcategory
     *
     * @return Lemma
     */
    public function setSubcategory(\MagicWordBundle\Entity\Lexicon\Subcategory $subcategory = null)
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \MagicWordBundle\Entity\Lexicon\Subcategory
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set gender
     *
     * @param \MagicWordBundle\Entity\Lexicon\Gender $gender
     *
     * @return Lemma
     */
    public function setGender(\MagicWordBundle\Entity\Lexicon\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \MagicWordBundle\Entity\Lexicon\Gender
     */
    public function getGender()
    {
        return $this->gender;
    }
}
