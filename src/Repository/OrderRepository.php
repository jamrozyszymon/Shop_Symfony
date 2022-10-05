<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    private const DAYS_BEFORE_REMOVE = 120;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function add(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function getOrderToRemove(): ORMQueryBuilder
    {
        return $this->createQueryBuilder('o')
            -> where('o.created_at < :date')
            ->setParameter(
                'date', new \DateTime(-self::DAYS_BEFORE_REMOVE.' days')
            );
    }

    public function deleteOrderToRemove()
    {
        return $this->getOrderToRemove()->delete()->getQuery() ->execute();
    }

    public function countOrderToRemove(): int
    {
        return $this->getOrderToRemove()->select('COUNT(o.id)')->getQuery()->getSingleScalarResult();
    }

}
