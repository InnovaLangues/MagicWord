<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation.
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="MagicWordBundle\Repository\InvitationRepository")
 */
class Invitation
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
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Player")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="MagicWordBundle\Entity\Player")
     */
    private $recipient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sentDate", type="datetime")
     */
    private $sentDate;

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
     * Set sentDate.
     *
     * @param \DateTime $sentDate
     *
     * @return Invitation
     */
    public function setSentDate($sentDate)
    {
        $this->sentDate = $sentDate;

        return $this;
    }

    /**
     * Get sentDate.
     *
     * @return \DateTime
     */
    public function getSentDate()
    {
        return $this->sentDate;
    }

    /**
     * Set sender
     *
     * @param \MagicWordBundle\Entity\Player $sender
     *
     * @return Invitation
     */
    public function setSender(\MagicWordBundle\Entity\Player $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \MagicWordBundle\Entity\Player
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set recipient
     *
     * @param \MagicWordBundle\Entity\Player $recipient
     *
     * @return Invitation
     */
    public function setRecipient(\MagicWordBundle\Entity\Player $recipient = null)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get recipient
     *
     * @return \MagicWordBundle\Entity\Player
     */
    public function getRecipient()
    {
        return $this->recipient;
    }
}
