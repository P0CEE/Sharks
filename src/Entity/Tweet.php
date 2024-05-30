<?php

namespace App\Entity;

use App\Repository\TweetRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: TweetRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Tweet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tweets')]
    #[ORM\JoinColumn(nullable: false)]
    private User $contentCreator;

    #[ORM\Column(type: 'string', length: 255)]
    private string $tweetId;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\OneToMany(targetEntity: Interaction::class, mappedBy: 'tweet', orphanRemoval: true)]
    private Collection $interactions;

    public function __construct()
    {
        $this->interactions = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentCreator(): ?User
    {
        return $this->contentCreator;
    }

    public function setContentCreator(User $contentCreator): self
    {
        $this->contentCreator = $contentCreator;
        return $this;
    }

    public function getTweetId(): ?string
    {
        return $this->tweetId;
    }

    public function setTweetId(string $tweetId): self
    {
        $this->tweetId = $tweetId;
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

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }


    public function getInteractions(): Collection
    {
        return $this->interactions;
    }
}
