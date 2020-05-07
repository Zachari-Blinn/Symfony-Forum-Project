<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TopicRepository")
 */
class Topic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="topic")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="topics")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HasReadTopic", mappedBy="topic")
     */
    private $hasReadTopics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="topic")
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPinned;

    /**
     * @ORM\Column(type="boolean")
     */
    private $allowAnonymous;

    public function __construct(Category $category, User $user)
    {
        $this->hasReadTopics = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->setIsActive(true);
        $this->setCategory($category);
        $this->comments = new ArrayCollection();
        $this->setUser($user);
        $this->setIsPinned(false);
        $this->setAllowAnonymous(true);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|HasReadTopic[]
     */
    public function getHasReadTopics(): Collection
    {
        return $this->hasReadTopics;
    }

    public function addHasRead(HasReadTopic $hasReadTopic): self
    {
        if (!$this->hasReadTopics->contains($hasReadTopic)) {
            $this->hasReadTopics[] = $hasReadTopic;
            $hasReadTopic->setTopic($this);
        }

        return $this;
    }

    public function removeHasRead(HasReadTopic $hasReadTopic): self
    {
        if ($this->hasReadTopics->contains($hasReadTopic)) {
            $this->hasReadTopics->removeElement($hasReadTopic);
            // set the owning side to null (unless already changed)
            if ($hasReadTopic->getTopic() === $this) {
                $hasReadTopic->setTopic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTopic($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getTopic() === $this) {
                $comment->setTopic(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIsPinned(): ?bool
    {
        return $this->isPinned;
    }

    public function setIsPinned(?bool $isPinned): self
    {
        $this->isPinned = $isPinned;

        return $this;
    }

    public function getAllowAnonymous(): ?bool
    {
        return $this->allowAnonymous;
    }

    public function setAllowAnonymous(bool $allowAnonymous): self
    {
        $this->allowAnonymous = $allowAnonymous;

        return $this;
    }
}
