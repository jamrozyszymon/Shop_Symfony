<?php

namespace App\Feature\Category;

use App\Entity\ProductCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractCategory extends ServiceEntityRepository
{
    protected static $connect;
    public $allCategories;
    public $categoryList;

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ManagerRegistry $registry,
        public UrlGeneratorInterface $urlGenerator,)
    {
        parent::__construct($registry, ProductCategory::class);
        $this->allCategories = $this->getCategories();
    }

    abstract public function getCategoriesList(array $categoriesArray);

    /**
     * Build nested tree of category
     */
    public function buildTree(int $parent_id= null): array
    {
        $subcategory = [];

        foreach($this->allCategories as $category) {
            if($category['parent_id'] == $parent_id) {
                $children = $this->buildTree($category['id']);
                    if($children) {
                        $category['children'] = $children;
                    }
                $subcategory[] = $category;
            }
        }
        return $subcategory;
    }

    private function getCategories(): array
    {
        if(self::$connect) {
            return self::$connect;
        } else {
            
            $conn = $this->getEntityManager()->getConnection();

            $sql = 'SELECT * FROM product_category';
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
            return self::$connect =$resultSet->fetchAllAssociative();
        }
    }
}
