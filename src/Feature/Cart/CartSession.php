<?php

namespace App\Feature\Cart;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartSession
{
    const CART_KEY = 'cart_id';

    public function __construct(
        protected RequestStack $requestStack, 
        private OrderRepository $cartRepository
    ){}
    
    /**
     * Retrieve cart in session
     */
    public function getCart(): ?Order
    {
        return $this->cartRepository->findOneby([
            'id'=>$this->getId(),
            'status'=> Order::STATUS
        ]);
    }

    /**
     * Set cart ID in session
     */
    public function setCartID(Order $cart): void
    {
        $this->getSession()->set(self::CART_KEY, $cart->getId());
    }

    /**
     * Return Cart ID
     */
    private function getId(): ?int
    {
        return $this->getSession()->get(self::CART_KEY);
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }

}
