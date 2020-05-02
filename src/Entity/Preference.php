<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PreferenceRepository")
 */
class Preference
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $userContactByEmail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $userPrivateMessage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $userPageVisible;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newsletter;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserContactByEmail(): ?bool
    {
        return $this->userContactByEmail;
    }

    public function setUserContactByEmail(bool $userContactByEmail): self
    {
        $this->userContactByEmail = $userContactByEmail;

        return $this;
    }

    public function getUserPrivateMessage(): ?bool
    {
        return $this->userPrivateMessage;
    }

    public function setUserPrivateMessage(bool $userPrivateMessage): self
    {
        $this->userPrivateMessage = $userPrivateMessage;

        return $this;
    }

    public function getUserPageVisible(): ?bool
    {
        return $this->userPageVisible;
    }

    public function setUserPageVisible(bool $userPageVisible): self
    {
        $this->userPageVisible = $userPageVisible;

        return $this;
    }

    public function getNewsletter(): ?bool
    {
        return $this->newsletter;
    }

    public function setNewsletter(bool $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
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
}
