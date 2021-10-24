<?php

namespace App\Repository;

use App\Entity\NotaFiscal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NotaFiscal|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotaFiscal|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotaFiscal[]    findAll()
 * @method NotaFiscal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotaFiscalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotaFiscal::class);
    }

    // /**
    //  * @return NotaFiscal[] Returns an array of NotaFiscal objects
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
    public function findOneBySomeField($value): ?NotaFiscal
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
