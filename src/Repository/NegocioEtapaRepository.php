<?php

namespace App\Repository;

use App\Entity\NegocioEtapa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NegocioEtapa|null find($id, $lockMode = null, $lockVersion = null)
 * @method NegocioEtapa|null findOneBy(array $criteria, array $orderBy = null)
 * @method NegocioEtapa[]    findAll()
 * @method NegocioEtapa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NegocioEtapaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NegocioEtapa::class);
    }

    // /**
    //  * @return NegocioEtapa[] Returns an array of NegocioEtapa objects
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
    public function findOneBySomeField($value): ?NegocioEtapa
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
