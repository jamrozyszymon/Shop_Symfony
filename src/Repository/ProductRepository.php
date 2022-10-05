<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, public PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * exlode string
     */
    private function explodeString(string $input): array
    {
        return explode(" ",$input);
    }

    /**
     * return products consider serching by
     * @param $page pagination
     * @param $searchString searching phrase
     */
    public function findBySearch($page, $searchString): PaginationInterface
    {
        $explodeString = $this->explodeString($searchString);
        
        $qb = $this->createQueryBuilder('p');

        foreach($explodeString as $key => $value)
        {
            $qb->andWhere('p.name LIKE :val'.$key)
            ->setParameter('val'.$key, '%'.$value.'%');
            
        }

        $qb->orderBy('p.name', 'ASC');
        $query = $qb->getQuery();

        $pagination = $this->paginator->paginate($query, $page, 12);
        
        return $pagination;
    }

    /**
     * return products consider sorting by
     * @param $category Category name from request
     * @param $page pagination
     * @param $sortMethod Method of sorting from form
     */
    public function findProductWithSorting($category, $page, ?string $sortMethod): PaginationInterface
    {
        if($sortMethod =='price_asc') {
            $qb = $this->createQueryBuilder('p')
            ->where('p.categories = :val')
            ->setParameter('val', $category)
            ->orderBy('p.price', 'ASC');
        } else if($sortMethod =='price_desc') {
            $qb = $this->createQueryBuilder('p')
            ->where('p.categories = :val')
            ->setParameter('val', $category)
            ->orderBy('p.price', 'DESC');
        } else {
            $qb = $this->createQueryBuilder('p')
            ->where('p.categories = :val')
            ->setParameter('val', $category)
            ->orderBy('p.name', 'ASC');
        }

        $query = $qb->getQuery();

        $pagination = $this->paginator->paginate($query, $page, 12);
        return $pagination;

    }
}
