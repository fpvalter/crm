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

    public function countContatosCliente(int $cliente_id)
    {
        return $this
            ->createQueryBuilder('c')
            ->select("count(c.id)")
            ->where('c.cliente = :cliente_id')
            ->setParameter('cliente_id', $cliente_id)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function listDataTable($cliente_id, $start, $length, $order, $search, $action_filter)
    {

        $search['value'] = str_replace("'", "", $search['value']);

        // Main Query
        $query = $this->createQueryBuilder('c')
            ->select('c.id', 'c.codigo', 'c.nome', 'c.email', 'c.telefone', "DATE_FORMAT(c.dataNascimento, '%d/%m/%Y') AS dataNascimento")
            ->andWhere('c.cliente = :cliente_id')
            ->setParameter('cliente_id', $cliente_id)
            ->setFirstResult($start)
            ->setMaxResults($length);

        // Count Query
        $countQuery = $this->createQueryBuilder('c')
            ->select('COUNT(c)')
            ->andWhere('c.cliente = :cliente_id')
            ->setParameter('cliente_id', $cliente_id);

        // Apply Action Filter
        if ($action_filter != null) {
            $query->andWhere($action_filter);
            $countQuery->andWhere($action_filter);
        }

        if ($search['value'] != '') {

            $filter_search = "c.nome LIKE '%" . $search['value'] . "%'";
            $filter_search .= " OR c.email LIKE '%" . $search['value'] . "%'";

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
                    $order_by = 'c.codigo';
                    break;
                case 2:
                    $order_by = 'c.nome';
                    break;
                case 3:
                    $order_by = 'c.email';
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
