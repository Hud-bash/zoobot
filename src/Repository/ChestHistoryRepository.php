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

    public function getCount()
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // 100 can be anything.  100 results seems like a large, yet small enough set to send for my purposes.
    public function findByPaginate($value): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id')
            ->setFirstResult($value[0]['page'])
            ->setMaxResults($value[0]['skip'] * 100)
            ->getQuery()
            ->getResult();
    }

    public function topChesties(int $x)
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.wallet) as count, w.wallet_id, w.name, w.animal')
            ->innerJoin('App:Wallet', 'w', 'WITH', 'c.wallet = w.wallet_id')
            ->groupBy('w.wallet_id, w.name, w.animal')
            ->orderBy('count', 'DESC')
            ->setMaxResults($x)
            ->getQuery()
            ->getResult();
    }

    public function findByWallet(string $wallet)
    {
        return $this->createQueryBuilder('c')
            ->where('c.wallet = :val')
            ->setParameter('val', $wallet)
            ->orderBy('c.timestamp', 'DESC')
            ->getQuery()
            ->getResult();
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
