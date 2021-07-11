<?php

namespace App\Repository;

use App\Entity\Nft;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Nft|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nft|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nft[]    findAll()
 * @method Nft[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NftRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nft::class);
    }

    public function getCount()
    {
        return $this->createQueryBuilder('n')
            ->select('count(n.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByPaginate($value): array
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.id', 'DESC')
            ->setFirstResult(($value['page'] - 1) * $value['skip'])
            ->setMaxResults($value['skip'])
            ->getQuery()
            ->getResult();
    }

    public function findOneByNftId($value): Nft
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.nft_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function updateLockState(array $locked)
    {
        // Set isLocked to true (1) for nft_ids in json webget
        $this->createQueryBuilder('n')
            ->set('n.isLocked', 1)
            ->where('n.nft_id IN (:ids)')
            ->setParameter('ids', $locked)
            ->getQuery()
            ->getResult();

        // Set isLocked to false (0) for nft_ids no longer present in json webget
        $this->createQueryBuilder('n')
            ->set('n.isLocked', 0)
            ->where('n.isLocked = 1 AND n.nft_id NOT IN (:ids)')
            ->setParameter('ids', $locked)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Nft[] Returns an array of Nft objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Nft
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
