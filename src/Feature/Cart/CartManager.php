<?php

namespace App\Feature\Cart;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

class CartManager
{
    public function __construct(
        private CartSession $cartSession,
        private OrderFactory $cartFactory,
        private EntityManagerInterface $entityManagerInterface
    )
    {}

    /**
     * Get current cart
     */
    public function getCurrentCart(): Order
    {
        $cart=$this->cartSession->getCart();
        
        if(!$cart) {
            $cart=$this->cartFactory->createOrder();
        }
        return $cart;
    }


    /**
     * Save cart in DB and Session
     */
    public function saveCart(Order $cart): void
    {
        $this->entityManagerInterface->persist($cart);
        $this->entityManagerInterface->flush();
        $this->cartSession->setCartID($cart);
    }


}
