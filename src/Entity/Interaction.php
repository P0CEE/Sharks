<?php

namespace App\Entity;

use App\Repository\InteractionRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InteractionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Interaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'interactions')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Tweet::class, inversedBy: "interactions", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private Tweet $tweet;

    #[ORM\Column(type: 'integer')]
    private int $favoriteCount;

    #[ORM\Column(type: 'integer')]
    private int $retweetCount;

    #[ORM\Column(type: 'integer')]
    private int $replyCount;

    #[ORM\Column(type: 'datetime')]
    private DateTime $lastActivity;

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function onPrePersistOrUpdate(): void
    {
        $this->lastActivity = new DateTime();
    }

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getTweet(): ?Tweet
    {
        return $this->tweet;
    }

    public function setTweet(Tweet $tweet): self
    {
        $this->tweet = $tweet;
        return $this;
    }

    public function getFavoriteCount(): ?int
    {
        return $this->favoriteCount;
    }

    public function setFavoriteCount(int $favoriteCount): self
    {
        $this->favoriteCount = $favoriteCount;
        return $this;
    }

    public function getRetweetCount(): ?int
    {
        return $this->retweetCount;
    }

    public function setRetweetCount(int $retweetCount): self
    {
        $this->retweetCount = $retweetCount;
        return $this;
    }

    public function getReplyCount(): ?int
    {
        return $this->replyCount;
    }

    public function setReplyCount(int $replyCount): self
    {
        $this->replyCount = $replyCount;
        return $this;
    }

    public function getLastActivity(): ?DateTime
    {
        return $this->lastActivity;
    }

    public function setLastActivity(DateTime $lastActivity): self
    {
        $this->lastActivity = $lastActivity;
        return $this;
    }
}
