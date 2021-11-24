<?php

namespace App\Repository;

use App\Entity\Produto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produto[]    findAll()
 * @method Produto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProdutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produto::class);
    }

    public function countProdutos()
    {
        return $this
            ->createQueryBuilder('p')
            ->select("count(p.id)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function listDataTable($start, $length, $order, $search, $action_filter, $advanced_filter)
    {

        $search['value'] = str_replace("'", "", $search['value']);

        // Main Query
        $query = $this->createQueryBuilder('p')
            ->select('p.id', 'p.codigo', 'p.descricao', 'p.categoria', 'f.descricao as familia', 'sf.descricao as subfamilia', 'g.descricao as grupo', 'm.descricao as marca')
            ->leftJoin('p.familia', 'f')
            ->leftJoin('p.subfamilia', 'sf')
            ->leftJoin('p.grupo', 'g')
            ->leftJoin('p.marca', 'm')
            ->setFirstResult($start)
            ->setMaxResults($length);

        // Count Query
        $countQuery = $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->leftJoin('p.familia', 'f')
            ->leftJoin('p.subfamilia', 'sf')
            ->leftJoin('p.grupo', 'g')
            ->leftJoin('p.marca', 'm');

        // Apply Action Filter
        if ($action_filter != null) {
            $query->andWhere($action_filter);
            $countQuery->andWhere($action_filter);
        }

        if ($advanced_filter['filtro_familia'] != '') {
            $filtro_familia = "p.familia = " . $advanced_filter['filtro_familia'];
            $query->andWhere($filtro_familia);
            $countQuery->andWhere($filtro_familia);
        }
        if ($advanced_filter['filtro_subfamilia'] != '') {
            $filtro_subfamilia = "p.subfamilia = " . $advanced_filter['filtro_subfamilia'];
            $query->andWhere($filtro_subfamilia);
            $countQuery->andWhere($filtro_subfamilia);
        }
        if ($advanced_filter['filtro_grupo'] != '') {
            $filtro_grupo = "p.grupo = " . $advanced_filter['filtro_grupo'];
            $query->andWhere($filtro_grupo);
            $countQuery->andWhere($filtro_grupo);
        }
        if ($advanced_filter['filtro_marca'] != '') {
            $filtro_marca = "p.marca = " . $advanced_filter['filtro_marca'];
            $query->andWhere($filtro_marca);
            $countQuery->andWhere($filtro_marca);
        }

        if ($search['value'] != '') {

            $filter_search = "p.descricao LIKE '%" . $search['value'] . "%'";
            $filter_search .= " OR p.codigo LIKE '" . $search['value'] . "%'";
            $filter_search .= " OR p.categoria LIKE '" . $search['value'] . "%'";

            $query->andWhere($filter_search);
            $countQuery->andWhere($filter_search);

        }

        // Order
        foreach ($order as $k => $o) {

            switch($o['column']) {
                case 0:
                    $order_by = 'p.id';
                    break;
                case 1:
                    $order_by = 'p.codigo';
                    break;
                case 2:
                    $order_by = 'p.descricao';
                    break;
                case 3:
                    $order_by = 'p.categoria';
                    break;
                case 4:
                    $order_by = 'f.descricao';
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

    public function findByCodigo($produto)
    {
        $codigo = $produto['codigo'];

        return $this->createQueryBuilder('p')
            ->andWhere('p.codigo = :codigo')
            ->setParameter('codigo', $codigo)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return Produto[] Returns an array of Produto objects
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
    public function findOneBySomeField($value): ?Produto
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
