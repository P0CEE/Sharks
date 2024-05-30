<?php 

namespace App\EventListener;

use App\Entity\Point;
use App\Repository\PointRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserPointsEventListener
{
    private PointRepository $pointRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(PointRepository $pointRepository, EntityManagerInterface $entityManager)
    {
        $this->pointRepository = $pointRepository;
        $this->entityManager = $entityManager;
    }

    public function onUserPointsUpdated(Point $point): void
    {
        // Récupérer tous les points triés par ordre décroissant
        $points = $this->pointRepository->findBy([], ['points' => 'DESC']);

        // Mettre à jour le classement de chaque point
        $rank = 1;
        foreach ($points as $point) {
            $point->setUserRank($rank++);
            $this->entityManager->persist($point);
        }

        $this->entityManager->flush();
    }
}
