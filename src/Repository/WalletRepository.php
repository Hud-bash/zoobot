<?php

namespace App\Repository;

use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wallet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wallet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wallet[]    findAll()
 * @method Wallet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    public function getCount()
    {
        return $this->createQueryBuilder('w')
            ->select('count(w.wallet_id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByPaginate($value): array
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.wallet_id', 'DESC')
            ->setFirstResult(($value['page'] - 1) * $value['skip'])
            ->setMaxResults($value['skip'])
            ->getQuery()
            ->getResult();
    }

    /**
    * @return Wallet[] Returns an array of Wallet objects
    */
    public function FindNullNames()
    {
        return $this->createQueryBuilder('w')
            ->select('w')
            ->where('w.name is null OR w.animal is null')
            ->getQuery()
            ->getResult();
    }

    public function findOneByWalletId($value): ?Wallet
    {
        return $this->createQueryBuilder('w')
            ->where('w.wallet_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Wallet[] Returns an array of Wallet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wallet
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
