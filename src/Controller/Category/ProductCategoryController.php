<?php

namespace App\Controller\Category;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Category\ProductSubCategoryTree;

class ProductCategoryController extends AbstractController
{
    /**
     * CORRECT - NOT USED
     * display main product category in Nav section (with href)
     */
    // public function categoryListNav(ManagerRegistry $doctrine)
    // {
    //     $categories = $doctrine->getRepository(ProductCategory::class)->findBy(['parent'=>null], ['name'=>'ASC']);
    //     return $this->render('category/category-list-nav.html.twig',[
    //         'categories'=>$categories
    //     ] );

    // }

    /**
     * display category and subcategory as a nasted list in Nav section (with href)
     */
    public function subCategoryListNav(ProductSubCategoryTree $categories): Response
    {
        $categories->getCategoriesList($categories->buildTree());
        return $this->render('category/subcategories-list.html.twig',[
            'categories'=>$categories->categoryList
        ] );

    }

}
