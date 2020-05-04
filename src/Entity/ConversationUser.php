<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConversationUserRepository")
 */
class ConversationUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="conversationUsers")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $toUser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PrivateMessage", mappedBy="conversationUser")
     */
    private $privateMessage;

    public function __construct()
    {
        $this->privateMessage = new ArrayCollection();
    }

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

    public function getToUser(): ?string
    {
        return $this->toUser;
    }

    public function setToUser(string $toUser): self
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * @return Collection|PrivateMessage[]
     */
    public function getPrivateMessage(): Collection
    {
        return $this->privateMessage;
    }

    public function addPrivateMessage(PrivateMessage $privateMessage): self
    {
        if (!$this->privateMessage->contains($privateMessage)) {
            $this->privateMessage[] = $privateMessage;
            $privateMessage->setConversationUser($this);
        }

        return $this;
    }

    public function removePrivateMessage(PrivateMessage $privateMessage): self
    {
        if ($this->privateMessage->contains($privateMessage)) {
            $this->privateMessage->removeElement($privateMessage);
            // set the owning side to null (unless already changed)
            if ($privateMessage->getConversationUser() === $this) {
                $privateMessage->setConversationUser(null);
            }
        }

        return $this;
    }
}
