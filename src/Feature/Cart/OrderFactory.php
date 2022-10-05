<?php

namespace App\Feature\Cart;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Product;

class OrderFactory
{
    public function createOrder(): Order
    {
        $order = new Order();
        $order
            ->setStatus(Order::STATUS)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        return $order;
    }

    public function createOrderDetails(Product $product): OrderDetail
    {
        $orderDetail = new OrderDetail();
        $orderDetail->setProducts($product);
        $orderDetail->setQuantity(1);
        return $orderDetail;
    }
}
