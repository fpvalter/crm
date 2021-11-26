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

    public function findByEtapaVendedorTransportadora($etapaId, $vendedorId, $transportadoraId)
    {
        $query = $this->createQueryBuilder('n')
            ->join('n.cliente', 'c')
            ->andWhere('n.status = :status')
            ->andWhere('n.negocioEtapa = :etapa_id')
            ->setParameter('status', NegocioStatus::ABERTO)
            ->setParameter('etapa_id', $etapaId)
            ->orderBy('n.id', 'ASC');

        if($vendedorId) {
            $query->andWhere('c.vendedor = :vendedor_id')
                ->setParameter('vendedor_id', $vendedorId);
        }
        if($transportadoraId) {
            $query->andWhere('c.transportadora = :transportadora_id')
                ->setParameter('transportadora_id', $transportadoraId );
        }

        return $query->getQuery()->getResult();
            
    }

    public function countNegocios()
    {
        return $this
            ->createQueryBuilder('c')
            ->select("count(c.id)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function listDataTable($start, $length, $order, $search, $action_filter, $advanced_filter)
    {

        $search['value'] = str_replace("'", "", $search['value']);

        // Main Query
        $query = $this->createQueryBuilder('n')
            ->select('n.id', 'n.titulo', 'c.razaoSocial', 'c.cnpj', 'cont.nome as contato', 'n.status')
            ->leftJoin('n.cliente', 'c')
            ->leftJoin('n.contato', 'cont')
            ->setFirstResult($start)
            ->setMaxResults($length);

        // Count Query
        $countQuery = $this->createQueryBuilder('n')
            ->select('COUNT(n)')
            ->leftJoin('n.cliente', 'c')
            ->leftJoin('n.contato', 'cont');

        // Apply Action Filter
        if ($action_filter != null) {
            $query->andWhere($action_filter);
            $countQuery->andWhere($action_filter);
        }

        if ($advanced_filter['filtro_transportadora'] != '') {
            $filtro_status = "c.transportadora =" . $advanced_filter['filtro_transportadora'];
            $query->andWhere($filtro_status);
            $countQuery->andWhere($filtro_status);
        }
        if ($advanced_filter['filtro_vendedor'] != '') {
            $filtro_vendedor = "c.vendedor = " . $advanced_filter['filtro_vendedor'];
            $query->andWhere($filtro_vendedor);
            $countQuery->andWhere($filtro_vendedor);
        }

        if ($search['value'] != '') {

            $filter_search = " n.id = '" . $search['value'] . "'";
            $filter_search .= " OR n.titulo LIKE '%" . $search['value'] . "%'";
            $filter_search .= " OR c.razaoSocial LIKE '%" . $search['value'] . "%'";
            $filter_search .= " OR c.nomeFantasia LIKE '%" . $search['value'] . "%'";
            $filter_search .= " OR c.cnpj LIKE '" . $search['value'] . "%'"; 

            $query->andWhere($filter_search);
            $countQuery->andWhere($filter_search);

        }

        // Order
        foreach ($order as $k => $o) {

            switch($o['column']) {
                case 0:
                    $order_by = 'c.id';
                    break;
                case 1:
                    $order_by = 'n.titulo';
                    break;
                case 2:
                    $order_by = 'c.razaoSocial';
                    break;
                case 3:
                    $order_by = 'c.cnpj';
                    break;
                case 4:
                    $order_by = 'cont.nome';
                    break;
                default:
                    $order_by = '';
            }

            if ($order_by != '') {
                $query->orderBy($order_by, $o['dir']);
            }

        }
        
        // Execute
        $results = $query->getQuery()->getArrayResult();
        $countResult = $countQuery->getQuery()->getSingleScalarResult();

        return array(
            "results" 		=> $results,
            "countResult"	=> $countResult
        );

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
