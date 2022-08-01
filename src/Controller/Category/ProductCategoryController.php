<?php

namespace App\Controller\Category;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\ProductCategory;

class ProductCategoryController extends AbstractController
{

    /**
     * display main product category in Nav section
     */
    public function categoryListNav(ManagerRegistry $doctrine)
    {
        $categories = $doctrine->getRepository(ProductCategory::class)->findBy(['parent'=>null], ['name'=>'ASC']);
        return $this->render('category/category-list-nav.html.twig',[
            'categories'=>$categories
        ] );

    }

    // public function categoryListNav(ProductCategoryTree $categories): Response
    // {
    //     $categories->getCategoriesList($categories->buildTree());
    //     dd($categories);
    //     return $this->render('category/category-list-nav.html.twig',[
    //         'categories'=>$categories->categoryList
    //     ] );

    // }



    #[Route('/product-list/category/{categoryname},{id}', name: 'app_product_list')]
    public function productList(ManagerRegistry $doctrine, int $id, ProductCategoryTree $categories): Response
    {
        $product = $doctrine->getRepository(Product::class)->findAll();

        $categories->getCategoryListAndParent($id);


        return $this->render('product/index.html.twig',[
            'subcategories'=> $categories,
            'products' =>$product
        ]);
    }
}
