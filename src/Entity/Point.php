<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PointRepository;

#[ORM\Entity(repositoryClass: PointRepository::class)]
#[ORM\Table(name: 'point')]
#[ORM\Index(name: 'user_rank_index', columns: ['user_rank'])]
#[ORM\Index(name: 'points_index', columns: ['points'])]
class Point
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'points')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column(type: 'integer', options: ['unsigned' => true])] 
    private int $points;

    #[ORM\Column(name: 'user_rank', type: 'integer', options: ['unsigned' => true])] 
    private int $userRank;

    // Getters and setters

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

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;
        return $this;
    }

    public function getUserRank(): ?int
    {
        return $this->userRank;
    }

    public function setUserRank(int $userRank): self
    {
        $this->userRank = $userRank;
        return $this;
    }
}
