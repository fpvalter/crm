<?php

namespace App\Repository;

use App\Entity\Negocio;
use App\Enum\NegocioStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Negocio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Negocio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Negocio[]    findAll()
 * @method Negocio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NegocioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Negocio::class);
    }

    public function findByEtapaVendedorDiaEntrega($etapaId, $vendedorId, $diasEntrega)
    {
        return $this->createQueryBuilder('n')
            ->join('n.cliente', 'c')
            ->andWhere('n.status = :status')
            ->andWhere('n.negocioEtapa = :etapa_id')
            ->andWhere('c.vendedor = :vendedor_id')
            ->andWhere('c.diaEntrega IN (:dia_entrega)')
            ->setParameter('status', NegocioStatus::ABERTO)
            ->setParameter('etapa_id', $etapaId)
            ->setParameter('vendedor_id', $vendedorId)
            ->setParameter('dia_entrega', implode("','", $diasEntrega) )
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult();
            
    }

    // /**
    //  * @return Negocio[] Returns an array of Negocio objects
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
    public function findOneBySomeField($value): ?Negocio
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
