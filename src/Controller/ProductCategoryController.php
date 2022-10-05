<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Feature\Category\ProductSubCategoryTree;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\ProductCategory;

class ProductCategoryController extends AbstractController
{
    /**
     * Display category and subcategory as a nasted list in Nav section (with link)
     */
    public function subCategoryListNav(ProductSubCategoryTree $categories): Response
    {
        $categories->getCategoriesList($categories->buildTree());

        return $this->render('category/subcategories-list.html.twig',[
            'categories'=>$categories->categoryList,
        ] );
    }

}
