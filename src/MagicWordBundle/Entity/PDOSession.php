<?php

namespace MagicWordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="session_pdo")
 * @ORM\Entity
 */
class PDOSession
{
    /**
     * @ORM\Column(name="sess_id", type="string", length=255)
     * @ORM\Id
     */
    private $session_id;

    /**
     * @ORM\Column(name="sess_data", type="blob")
     */
    private $session_value;

    /**
     * @ORM\Column(name="sess_time", type="integer")
     */
    private $session_time;

    /**
     * @ORM\Column(name="sess_lifetime", type="integer")
     */
    private $sess_lifetime;

    /**
     * Set sessionId.
     *
     * @param string $sessionId
     *
     * @return PDOSession
     */
    public function setSessionId($sessionId)
    {
        $this->session_id = $sessionId;

        return $this;
    }

    /**
     * Get sessionId.
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * Set sessionValue.
     *
     * @param string $sessionValue
     *
     * @return PDOSession
     */
    public function setSessionValue($sessionValue)
    {
        $this->session_value = $sessionValue;

        return $this;
    }

    /**
     * Get sessionValue.
     *
     * @return string
     */
    public function getSessionValue()
    {
        return $this->session_value;
    }

    /**
     * Set sessionTime.
     *
     * @param int $sessionTime
     *
     * @return PDOSession
     */
    public function setSessionTime($sessionTime)
    {
        $this->session_time = $sessionTime;

        return $this;
    }

    /**
     * Get sessionTime.
     *
     * @return int
     */
    public function getSessionTime()
    {
        return $this->session_time;
    }

    /**
     * Set sess_lifetime.
     *
     * @param int $sessLifetime
     *
     * @return PDOSession
     */
    public function setSessLifetime($sessLifetime)
    {
        $this->sess_lifetime = $sessLifetime;

        return $this;
    }

    /**
     * Get sess_lifetime.
     *
     * @return int
     */
    public function getSessLifetime()
    {
        return $this->sess_lifetime;
    }
}
