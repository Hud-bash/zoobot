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

    public function findAllDescending(string $column): array
    {
        return $this->findBy(array(), array($column => 'DESC'));
    }

    public function topBuyer(int $x)
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.seller) as count, w.wallet_id')
            ->innerJoin('App:Wallet', 'w', 'WITH', 'm.seller = w.wallet_id')
            ->groupBy('w.wallet_id')
            ->orderBy('count', 'DESC')
            ->setMaxResults($x)
            ->getQuery()
            ->getResult();
    }

    public function topSeller(int $x)
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.buyer) as count, w.wallet_id')
            ->innerJoin('App:Wallet', 'w', 'WITH', 'm.buyer = w.wallet_id')
            ->groupBy('w.wallet_id')
            ->orderBy('count', 'DESC')
            ->setMaxResults($x)
            ->getQuery()
            ->getResult();
    }

    public function findbyWalletId($value)
    {
        $buy = $this->createQueryBuilder('m')
            ->andWhere('m.buyer = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();

        $sell = $this->createQueryBuilder('m')
            ->andWhere('m.seller = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();

        return
            [
                'sell' => $sell,
                'buy' => $buy,
            ];
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
