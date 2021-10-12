<?php

namespace App\Repository;

use App\Entity\Contato;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contato|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contato|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contato[]    findAll()
 * @method Contato[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContatoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contato::class);
    }

    // /**
    //  * @return Contato[] Returns an array of Contato objects
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
    public function findOneBySomeField($value): ?Contato
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
