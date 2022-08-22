<?php

namespace App\Controller;

use App\Feature\Cart\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CartType;
use Symfony\Component\HttpFoundation\Request;


class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function cart(Request $request, CartManager $cartManager): Response
    {
        $cart = $cartManager->getCurrentCart();
        $form = $this->createForm(CartType::class, $cart);

 

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setUpdatedAt(new \DateTime());
            $cartManager->saveCart($cart);

            return $this->redirectToRoute('app_cart');
        }


        return $this->render('cart/cart.html.twig', [
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }

}