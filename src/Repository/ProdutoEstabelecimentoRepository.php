<?php

namespace App\Repository;

use App\Entity\ProdutoEstabelecimento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProdutoEstabelecimento|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProdutoEstabelecimento|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProdutoEstabelecimento[]    findAll()
 * @method ProdutoEstabelecimento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProdutoEstabelecimentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProdutoEstabelecimento::class);
    }

    // /**
    //  * @return ProdutoEstabelecimento[] Returns an array of ProdutoEstabelecimento objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProdutoEstabelecimento
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
