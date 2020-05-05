<?php

namespace App\Entity;

use App\Entity\Topic;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
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
    private $author;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Topic", inversedBy="comments")
     */
    private $topic;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HasReadComment", mappedBy="comment")
     */
    private $hasReadComments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     */
    private $user;

    public function __construct(Topic $topic)
    {
        $this->setTopic($topic);
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->hasReadComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return Collection|HasReadComment[]
     */
    public function getHasReadComments(): Collection
    {
        return $this->hasReadComments;
    }

    public function addHasReadComment(HasReadComment $hasReadComment): self
    {
        if (!$this->hasReadComments->contains($hasReadComment)) {
            $this->hasReadComments[] = $hasReadComment;
            $hasReadComment->setComment($this);
        }

        return $this;
    }

    public function removeHasReadComment(HasReadComment $hasReadComment): self
    {
        if ($this->hasReadComments->contains($hasReadComment)) {
            $this->hasReadComments->removeElement($hasReadComment);
            // set the owning side to null (unless already changed)
            if ($hasReadComment->getComment() === $this) {
                $hasReadComment->setComment(null);
            }
        }

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
