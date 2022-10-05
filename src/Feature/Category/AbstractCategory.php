<?php

namespace App\Feature\Category;

use App\Entity\ProductCategory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Get all ProductCategory. Create Array. Singleton
 */
abstract class AbstractCategory
{
    protected static $connect;
    public $allCategories;
    public $categoryList;

    public function __construct(
        protected ManagerRegistry $doctrine,
        public UrlGeneratorInterface $urlGenerator,)
    {
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
            $categories = $this->doctrine->getRepository(ProductCategory::class)
            ->findAllCategories();
            return self::$connect=$categories;
        }
    }
}