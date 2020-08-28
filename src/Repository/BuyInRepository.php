<?php

namespace App\Repository;

use App\Entity\BuyIn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuyIn|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuyIn|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuyIn[]    findAll()
 * @method BuyIn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuyInRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuyIn::class);
    }

    // /**
    //  * @return BuyIn[] Returns an array of BuyIn objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BuyIn
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
