<?php

namespace App\Repository;

use App\Entity\Market;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Market|null find($id, $lockMode = null, $lockVersion = null)
 * @method Market|null findOneBy(array $criteria, array $orderBy = null)
 * @method Market[]    findAll()
 * @method Market[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Market::class);
    }
    public function getCount()
    {
        return $this->createQueryBuilder('m')
            ->select('count(m.nft)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByPaginate($value): array
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.nft', 'DESC')
            ->setFirstResult(($value['page'] - 1) * $value['skip'])
            ->setMaxResults($value['skip'])
            ->getQuery()
            ->getResult();
    }

    public function cleanMarket(array $currentMarket)
    {
        //Purge table of any listings with nft_id
        $this->createQueryBuilder('')
            ->delete("App:Market", 'm')
            ->where('m.nft NOT IN (:ids)')
            ->setParameter('ids', $currentMarket)
            ->getQuery()
            ->getResult();
    }

    public function findByNftId($value): ?Market
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.nft = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByWalletId($wallet)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.seller = :val')
            ->setParameter('val', $wallet)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Market[] Returns an array of Market objects
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
    public function findOneBySomeField($value): ?Market
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
