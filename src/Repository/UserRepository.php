<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Retourne tous les utilisateurs qui sont créateurs de contenu.
     *
     * @return User[]
     */
    public function findContentCreators(): array
    {
        return $this->createQueryBuilder('u')
            ->select('u.id, u.username, u.name, u.profileImageUrl, u.followersCount, u.followingCount')
            ->andWhere('u.isContentCreator = :isContentCreator')
            ->setParameter('isContentCreator', true)
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne une instance de Paginator pour paginer les utilisateurs.
     *
     * @param int $page Le numéro de page
     * @param int $pageSize La taille de la page
     * @return Paginator
     */
    public function findAllUsersPaginated(int $page, int $pageSize): Paginator
    {
        $qb = $this->createQueryBuilder('u');

        $query = $qb
            ->getQuery()
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);

        $paginator = new Paginator($query, $fetchJoinCollection = true);
        $paginator->setUseOutputWalkers(false);

        return $paginator;
    }

    public function findAllUsersWithPointsAndRank(): array
    {
        return $this->createQueryBuilder('u')
            ->select('u.username','u.name', 'u.profileImageUrl', 'u.isContentCreator', 'u.name', 'p.points', 'p.userRank')
            ->leftJoin('u.points', 'p')
            ->orderBy('p.userRank', 'ASC') 
            ->getQuery()
            ->getResult();
    }   
}
