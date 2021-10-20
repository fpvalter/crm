<?php

namespace App\Repository;

use App\Entity\Seguimento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Seguimento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seguimento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seguimento[]    findAll()
 * @method Seguimento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeguimentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seguimento::class);
    }

    // /**
    //  * @return Seguimento[] Returns an array of Seguimento objects
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
    public function findOneBySomeField($value): ?Seguimento
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
