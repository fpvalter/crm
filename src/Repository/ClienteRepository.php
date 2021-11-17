<?php

namespace App\Repository;

use App\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cliente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cliente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cliente[]    findAll()
 * @method Cliente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cliente::class);
    }

    public function countClientes()
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
        $query = $this->createQueryBuilder('c')
            ->select('c.id', 'c.codigo', 'c.razaoSocial', 'c.nomeFantasia', 'cid.municipio as cidade', 'cid.uf', 'c.cnpj')
            ->leftJoin('c.cidade', 'cid')
            ->setFirstResult($start)
            ->setMaxResults($length);

        // Count Query
        $countQuery = $this->createQueryBuilder('c')
            ->select('COUNT(c)');

        // Apply Action Filter
        if ($action_filter != null) {
            $query->andWhere($action_filter);
            $countQuery->andWhere($action_filter);
        }

        if ($advanced_filter['filtro_dia_entrega'] != '') {
            $filtro_status = "c.diaEntrega IN ('" . implode("','", $advanced_filter['filtro_dia_entrega']) . "')";
            $query->andWhere($filtro_status);
            $countQuery->andWhere($filtro_status);
        }
        if ($advanced_filter['filtro_vendedor'] != '') {
            $filtro_vendedor = "c.vendedor = " . $advanced_filter['filtro_vendedor'];
            $query->andWhere($filtro_vendedor);
            $countQuery->andWhere($filtro_vendedor);
        }

        if ($search['value'] != '') {

            $filter_search = "c.razaoSocial LIKE '%" . $search['value'] . "%'";
            $filter_search .= " OR c.nomeFantasia LIKE '%" . $search['value'] . "%'";
            $filter_search .= " OR c.cnpj LIKE '" . $search['value'] . "%'"; 
            $filter_search .= " OR c.codigo = '" . $search['value'] . "'";

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
                    $order_by = 'c.razaoSocial';
                    break;
                case 2:
                    $order_by = 'c.nomeFantasia';
                    break;
                case 3:
                    $order_by = 'c.cnpj';
                    break;
                case 4:
                    $order_by = 'cid.municipio';
                    break;
                case 5:
                    $order_by = 'cid.uf';
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
}
