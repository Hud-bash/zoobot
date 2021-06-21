<?php

namespace App\Repository;

use App\Entity\MarketHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MarketHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketHistory[]    findAll()
 * @method MarketHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarketHistory::class);
    }

    // /**
    //  * @return MarketHistory[] Returns an array of MarketHistory objects
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
    public function findOneBySomeField($value): ?MarketHistory
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
