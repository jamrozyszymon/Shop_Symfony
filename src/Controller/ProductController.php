<?php

namespace App\Controller;

use App\Entity\OrderDetail;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    /**
     * display products by subcategory
     */
    #[Route('/product-list/category/{categoryname},{id}/{!page?1}', name: 'app_product_list')]
    public function productList(ManagerRegistry $doctrine, int $id, $page, Request $request): Response
    {
        $products = $doctrine->getRepository(Product::class)
        ->findProductWithSorting(['categories' => $id], $page ,$request->get('sortby'));

        return $this->render('product/product-list.html.twig',[
            'products' => $products
        ]);
    }
    
    /**
     * display searching products
     */
    #[Route('/product-list/{!page?1}', name: 'app_producy_search_list')]
    public function productSearchList(ManagerRegistry $doctrine, $page, Request $request): Response
    {
        $products=$doctrine->getRepository(Product::class)
        ->findBySearch($page, $request->get('searchby'));

        return $this->render('product/product-list.html.twig',[
            'products' => $products
        ]);
    }

    /**
     * display top sales products
     */
    #[Route('/product-top-list', name: 'app_product_top_list')]
    public function productTopList(EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $repository = $entityManager->getRepository(OrderDetail::class);
        $listProducts=$repository->findTopSalesProducts(100,12);
        $key = array_column($listProducts, 'products_id');

        $products = $doctrine->getRepository(Product::class)->findBy(array('id' =>$key));

        return $this->render('product/product-top-list.html.twig',[
            'products' => $products,
        ]);
    }

}
