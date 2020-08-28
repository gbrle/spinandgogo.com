<?php

namespace App\Repository;

use App\Entity\Multiplicator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Multiplicator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Multiplicator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Multiplicator[]    findAll()
 * @method Multiplicator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MultiplicatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Multiplicator::class);
    }

    // /**
    //  * @return Multiplicator[] Returns an array of Multiplicator objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Multiplicator
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
