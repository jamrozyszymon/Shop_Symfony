<?php

namespace App\Repository;

use App\Entity\OrderDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Doctrine\DBAL\ParameterType;

/**
 * @extends ServiceEntityRepository<OrderDetail>
 *
 * @method OrderDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDetail[]    findAll()
 * @method OrderDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDetail::class);
    }

    public function add(OrderDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * CHANGE LIMITS AFTER INCREASE DATABASE
     * return top products with highest sales (the highest number of sales one) in specified number of last sales
     * @param int $order - limit of last sales (e.g. 1000)
     * @param int $product - limit of products with highest sales from specified order (e.g. 50)
     */
    public function findTopSalesProducts($order, $product)
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT products_id, SUM(quantity) AS num_pr FROM order_detail 
            WHERE orders_id IN 
            (SELECT * FROM
            (select id FROM `order` ORDER BY created_at DESC LIMIT :orderlimit) AS q)
            GROUP BY products_id ORDER BY num_pr DESC LIMIT :productlimit';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":orderlimit", $order, ParameterType::INTEGER);
        $stmt->bindValue(":productlimit",$product, ParameterType::INTEGER);

        $resultSet = $stmt->executeQuery();
            
        return $resultSet->fetchAllAssociative();

    }

//    /**
//     * @return OrderDetail[] Returns an array of OrderDetail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderDetail
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
