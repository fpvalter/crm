<?php

namespace App\Repository;

use App\Entity\Notification;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    public function findByUserAndDisplayed(int $userId, bool $displayed)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.userTarget = :user_target')
            ->andWhere('n.scheduledAt <= :scheduled')
            ->andWhere('n.displayed = :displayed')
            ->setParameter('user_target', $userId)
            ->setParameter('scheduled', (new \DateTime())->modify("+5 minute"))
            ->setParameter('displayed', $displayed)
            ->orderBy('n.scheduledAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function countNotifications()
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
            ->select('n.id', 'n.descricao', 'neg.id as negocio', 'c.razaoSocial', "DATE_FORMAT(n.scheduledAt, '%d/%m/%Y %H:%i') AS agendado", "DATE_FORMAT(n.createdAt, '%d/%m/%Y') AS criado", 'n.displayed', 'u.email')
            ->leftJoin('n.negocio', 'neg')
            ->leftJoin('neg.cliente', 'c')
            ->leftJoin('n.userTarget', 'u')
            ->setFirstResult($start)
            ->setMaxResults($length);

        // Count Query
        $countQuery = $this->createQueryBuilder('n')
            ->select('COUNT(n)')
            ->leftJoin('n.userTarget', 'u');

        // Apply Action Filter
        if ($action_filter != null) {
            $query->andWhere($action_filter);
            $countQuery->andWhere($action_filter);
        }

        if ($advanced_filter['filtro_user'] != '') {
            $filtro_user = "n.userTarget = " . $advanced_filter['filtro_user'];
            $query->andWhere($filtro_user);
            $countQuery->andWhere($filtro_user);
        }

        if ($search['value'] != '') {

            $filter_search = " OR n.descricao LIKE '%" . $search['value'] . "%'";

            $query->andWhere($filter_search);
            $countQuery->andWhere($filter_search);

        }

        // Order
        foreach ($order as $k => $o) {

            switch($o['column']) {
                case 0:
                    $order_by = 'n.id';
                    break;
                case 1:
                    $order_by = 'n.descricao';
                    break;
                case 2:
                    $order_by = 'n.createdAt';
                    break;
                case 3:
                    $order_by = 'n.scheduledAt';
                    break;
                case 4:
                    $order_by = 'n.displayed';
                    break;
                case 4:
                    $order_by = 'u.email';
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
    //  * @return Notification[] Returns an array of Notification objects
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
    public function findOneBySomeField($value): ?Notification
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
