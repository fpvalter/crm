<?php

namespace App\Repository;

use App\Entity\Estabelecimento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Estabelecimento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estabelecimento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estabelecimento[]    findAll()
 * @method Estabelecimento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstabelecimentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estabelecimento::class);
    }

    // /**
    //  * @return Estabelecimento[] Returns an array of Estabelecimento objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Estabelecimento
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
