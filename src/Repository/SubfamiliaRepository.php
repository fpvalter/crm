<?php

namespace App\Repository;

use App\Entity\Subfamilia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subfamilia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subfamilia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subfamilia[]    findAll()
 * @method Subfamilia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubfamiliaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subfamilia::class);
    }

    // /**
    //  * @return Subfamilia[] Returns an array of Subfamilia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Subfamilia
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
