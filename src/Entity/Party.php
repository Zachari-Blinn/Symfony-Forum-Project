<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartyRepository")
 */
class Party
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $partyAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expireAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participate", mappedBy="party")
     */
    private $participate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAtive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="parties")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localization;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cautionPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $locationPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $freelancePrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberLocation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $allowAnonymous;

    public function __construct()
    {
        $this->participates = new ArrayCollection();
        $this->setUpdatedAt(new \DateTime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPartyAt(): ?\DateTimeInterface
    {
        return $this->partyAt;
    }

    public function setPartyAt(\DateTimeInterface $partyAt): self
    {
        $this->partyAt = $partyAt;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(?\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;

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

    /**
     * @return Collection|Participate[]
     */
    public function getParticipate(): Collection
    {
        return $this->participates;
    }

    public function addParticipate(Participate $participate): self
    {
        if (!$this->participates->contains($participate)) {
            $this->participates[] = $participate;
            $participate->setParty($this);
        }

        return $this;
    }

    public function removeParticipate(Participate $participate): self
    {
        if ($this->participates->contains($participate)) {
            $this->participates->removeElement($participate);
            // set the owning side to null (unless already changed)
            if ($participate->getParty() === $this) {
                $participate->setParty(null);
            }
        }

        return $this;
    }

    public function getIsAtive(): ?bool
    {
        return $this->isAtive;
    }

    public function setIsAtive(bool $isAtive): self
    {
        $this->isAtive = $isAtive;

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

    public function getLocalization(): ?string
    {
        return $this->localization;
    }

    public function setLocalization(string $localization): self
    {
        $this->localization = $localization;

        return $this;
    }

    public function getCautionPrice(): ?float
    {
        return $this->cautionPrice;
    }

    public function setCautionPrice(?float $cautionPrice): self
    {
        $this->cautionPrice = $cautionPrice;

        return $this;
    }

    public function getLocationPrice(): ?float
    {
        return $this->locationPrice;
    }

    public function setLocationPrice(?float $locationPrice): self
    {
        $this->locationPrice = $locationPrice;

        return $this;
    }

    public function getFreelancePrice(): ?float
    {
        return $this->freelancePrice;
    }

    public function setFreelancePrice(?float $freelancePrice): self
    {
        $this->freelancePrice = $freelancePrice;

        return $this;
    }

    public function getNumberLocation(): ?int
    {
        return $this->numberLocation;
    }

    public function setNumberLocation(?int $numberLocation): self
    {
        $this->numberLocation = $numberLocation;

        return $this;
    }

    public function getAllowAnonymous(): ?bool
    {
        return $this->allowAnonymous;
    }

    public function setAllowAnonymous(?bool $allowAnonymous): self
    {
        $this->allowAnonymous = $allowAnonymous;

        return $this;
    }
}
