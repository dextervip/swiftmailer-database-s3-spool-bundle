<?php

namespace Cgonser\SwiftMailerDatabaseS3SpoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * MailQueueTransport
 *
 * @ORM\Table(name="cgonser_mail_queue_transport")
 * @ORM\Entity(repositoryClass="Cgonser\SwiftMailerDatabaseS3SpoolBundle\Repository\MailQueueTransportRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class MailQueueTransport
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255, nullable=false)
     */
    private $alias;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false, options={"default":true})
     */
    private $enabled = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paused", type="boolean", nullable=false, options={"default":false})
     */
    private $paused = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="default", type="boolean", nullable=false,options={"default":false})
     */
    private $default = false;

    /**
     * @var string
     *
     * @ORM\Column(name="sender", type="string", length=255, nullable=true)
     */
    private $sender;

    /**
     * @var string
     *
     * @ORM\Column(name="host", type="string", length=255)
     */
    private $host;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="port", type="integer")
     */
    private $port;

    /**
     * @var string
     *
     * @ORM\Column(name="encryption", type="string", length=255)
     */
    private $encryption;

    /**
     * @var array
     *
     * @ORM\Column(name="tags", type="json_array")
     */
    private $tags;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return MailQueueTransport
     */
    public function setName(string $name): MailQueueTransport
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return MailQueueTransport
     */
    public function setEnabled(bool $enabled): MailQueueTransport
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPaused(): bool
    {
        return $this->paused;
    }

    /**
     * @param bool $paused
     * @return MailQueueTransport
     */
    public function setPaused(bool $paused): MailQueueTransport
    {
        $this->paused = $paused;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->default;
    }

    /**
     * @param bool $default
     * @return MailQueueTransport
     */
    public function setDefault(bool $default): MailQueueTransport
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @return string
     */
    public function getSender(): ?string
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     * @return MailQueueTransport
     */
    public function setSender(string $sender): MailQueueTransport
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return MailQueueTransport
     */
    public function setHost(string $host): MailQueueTransport
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return MailQueueTransport
     */
    public function setUsername(string $username): MailQueueTransport
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return MailQueueTransport
     */
    public function setPassword(string $password): MailQueueTransport
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @param string $port
     * @return MailQueueTransport
     */
    public function setPort(string $port): MailQueueTransport
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getEncryption(): string
    {
        return $this->encryption;
    }

    /**
     * @param string $encryption
     * @return MailQueueTransport
     */
    public function setEncryption(string $encryption): MailQueueTransport
    {
        $this->encryption = $encryption;
        return $this;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     * @return MailQueueTransport
     */
    public function setTags(array $tags): MailQueueTransport
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     * @return MailQueueTransport
     */
    public function setAlias(string $alias): MailQueueTransport
    {
        $this->alias = $alias;
        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }


}
