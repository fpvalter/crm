<?php

namespace App\Repository;

use App\Entity\ClienteInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClienteInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClienteInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClienteInfo[]    findAll()
 * @method ClienteInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClienteInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClienteInfo::class);
    }

    // /**
    //  * @return ClienteInfo[] Returns an array of ClienteInfo objects
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
    public function findOneBySomeField($value): ?ClienteInfo
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
