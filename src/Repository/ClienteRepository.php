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

    public function listDataTable($start, $length, $order, $search, $action_filter)
    {

        $search['value'] = str_replace("'", "", $search['value']);

        // Main Query
        $query = $this->createQueryBuilder('c')
            ->select('c.id', 'c.codigo', 'c.razaoSocial', "'Limeira' as cidade", "'SP' as uf", 'c.cnpj')
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

        if ($search['value'] != '') {

            $filter_search = "c.razaoSocial LIKE '%" . $search['value'] . "%'";
            $filter_search .= " OR c.cnpj LIKE '" . $search['value'] . "%'"; 
            $filter_search .= " OR c.codigo = '" . $search['value'] . "'";

            $query->andWhere($filter_search);
            $countQuery->andWhere($filter_search);

        }

        // Order
        foreach ($order as $k => $o) {

            switch($o['column']) {
                case 0:
                    $order_by = 'c.codigo';
                    break;
                case 1:
                    $order_by = 'c.razaoSocial';
                    break;
                case 2:
                    $order_by = 'c.cnpj';
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
