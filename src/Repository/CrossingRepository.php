<?php

namespace App\Repository;

use App\Entity\Crossing;
use App\Entity\Dog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Crossing>
 */
class CrossingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Crossing::class);
    }

    /**
     * @return array<int, Crossing>
     */
    public function findForDate(Dog $dog, \DateTime $date): array
    {
        /** @var array<int, Crossing> $result * */
        $result = $this->createQueryBuilder('c')
            ->andWhere('c.dog = :dog')
            ->andWhere('c.date = :date')
            ->setParameter('dog', $dog)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();

        return $result;
    }
}
