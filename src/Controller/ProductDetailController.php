<?php

namespace App\Controller;

use App\Entity\OrderDetail;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Entity\User;
use App\Feature\Cart\CartManager;
use App\Form\AddToCartFormType;
use Symfony\Component\HttpFoundation\Request;

class ProductDetailController extends AbstractController
{
    #[Route('/product/detail/{productname},{id}', name: 'app_product_detail')]
    public function index(ManagerRegistry $doctrine, int $id, Request $request, Product $product, CartManager $cartManager): Response
    {
        $products = $doctrine->getRepository(Product::class)
        ->findOneBy(['id'=>$id]);

        if($this->getUser()) {
            $user = new User();
            $user=$this->getUser();
        } else {
            $user=null;
        }

        $form = $this->createForm(AddToCartFormType::class);
        $form->handleRequest($request);

        $orderDetail = new OrderDetail();

        if ($form->isSubmitted() && $form->isValid()) {
            $orderDetail = $form->getData();
            $orderDetail->setProducts($product);

            $cart = $cartManager->getCurrentCart();
            $cart 
            ->addOrderDetail($orderDetail)
            ->setUpdatedAt(new \DateTime())
            ->setUsers($user);

            $cartManager->saveCart($cart);
        }

        return $this->render('product/product-detail.html.twig', [
            'product' =>$products,
            'addProductForm' =>$form->createView()
        ]);
    }
}