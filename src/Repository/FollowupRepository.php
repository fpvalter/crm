<?php

namespace App\Repository;

use App\Entity\Followup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Followup|null find($id, $lockMode = null, $lockVersion = null)
 * @method Followup|null findOneBy(array $criteria, array $orderBy = null)
 * @method Followup[]    findAll()
 * @method Followup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Followup::class);
    }

    public function findFollowupsTimelineByCliente(int $cliente_id, int $page)
    {

        $offset = $page * 10;

        return $this->createQueryBuilder('f')
            ->andWhere('f.cliente = :cliente_id')
            ->setParameter('cliente_id', $cliente_id)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->setFirstResult($offset)
            ->orderBy('f.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Followup[] Returns an array of Followup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Followup
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
