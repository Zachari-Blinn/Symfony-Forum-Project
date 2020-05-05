<?php

namespace App\Entity;

use DateTime;
use App\Entity\User;
use App\Entity\Party;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipateRepository")
 */
class Participate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="integer")
     */
    private $visitor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $equipment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="participate")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Party", inversedBy="participate")
     */
    private $party;

    /**
     * @ORM\Column(type="boolean")
     */
    private $locomotion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $author;

    public function __construct(Party $party, User $user = null)
    {
        $this->setParty($party);
        $this->setUser($user);
        $this->setUpdatedAt(new \DateTime('now'));
        $this->setCreatedAt(new \DateTime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getVisitor(): ?int
    {
        return $this->visitor;
    }

    public function setVisitor(int $visitor): self
    {
        $this->visitor = $visitor;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getEquipment(): ?int
    {
        return $this->equipment;
    }

    public function setEquipment(int $equipment): self
    {
        $this->equipment = $equipment;

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

    public function getParty(): ?Party
    {
        return $this->party;
    }

    public function setParty(?Party $party): self
    {
        $this->party = $party;

        return $this;
    }

    public function getLocomotion(): ?bool
    {
        return $this->locomotion;
    }

    public function setLocomotion(bool $locomotion): self
    {
        $this->locomotion = $locomotion;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }
}
