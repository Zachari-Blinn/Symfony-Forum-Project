<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $privateMessage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $topicReply;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPrivateMessage(): ?bool
    {
        return $this->privateMessage;
    }

    public function setPrivateMessage(bool $privateMessage): self
    {
        $this->privateMessage = $privateMessage;

        return $this;
    }

    public function getTopicReply(): ?bool
    {
        return $this->topicReply;
    }

    public function setTopicReply(bool $topicReply): self
    {
        $this->topicReply = $topicReply;

        return $this;
    }
}
