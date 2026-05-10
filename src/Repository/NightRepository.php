<?php

namespace App\Repository;

use App\Entity\Dog;
use App\Entity\Night;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Night>
 */
class NightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Night::class);
    }

    public function findLastNightForDate(Dog $dog, \DateTime $date): ?Night
    {
        try {
            /** @var ?Night $result * */
            $result = $this->createQueryBuilder('n')
                ->andWhere('n.dog = :dog')
                ->andWhere('DATE(n.end) = :date')
                ->setParameter('dog', $dog)
                ->setParameter('date', $date)
                ->getQuery()
                ->getOneOrNullResult();

            return $result;
        } catch (NonUniqueResultException) {
            return null;
        }
    }
}
