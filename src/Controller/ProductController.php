<?php

namespace App\Controller;

use App\Entity\ProductCategory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Category\ProductCategoryTree;
use App\Entity\Product;
use Knp\Component\Pager\PaginatorInterface;

class ProductController extends AbstractController
{

    #[Route('/product-list/category/{categoryname},{id}', name: 'app_product_list')]
    public function productList(ManagerRegistry $doctrine, int $id, ProductCategoryTree $categories, PaginatorInterface $paginator, Request $request): Response
    {
        $products = $doctrine->getRepository(Product::class)->findAll();

        $categories->getCategoryListAndParent($id);

        $paginate = $paginator->paginate(
            $products,
            $request->query->getInt('page',1), 12
        );


        return $this->render('product/product-list.html.twig',[
            'subcategories'=> $categories,
            //'products' =>$products
            'paginations' => $paginate
        ]);
    }

}
