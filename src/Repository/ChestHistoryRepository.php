<?php

namespace App\Repository;

use App\Entity\ChestHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChestHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChestHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChestHistory[]    findAll()
 * @method ChestHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChestHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChestHistory::class);
    }

    // /**
    //  * @return ChestHistory[] Returns an array of ChestHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChestHistory
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
