<?php

namespace App\Repository;

use App\Entity\Dog;
use App\Entity\OCD;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OCD>
 */
class OCDRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OCD::class);
    }

    /**
     * @return array<int, OCD>
     */
    public function findForDate(Dog $dog, \DateTime $date): array
    {
        /** @var array<int, OCD> $result * */
        $result = $this->createQueryBuilder('c')
            ->andWhere('c.dog = :dog')
            ->andWhere('DATE(c.date) = :date')
            ->setParameter('dog', $dog)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();

        return $result;
    }
}
