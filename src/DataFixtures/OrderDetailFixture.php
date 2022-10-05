<?php

namespace App\DataFixtures;

use App\Entity\OrderDetail;
use App\Entity\Product;
use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderDetailFixture extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<300; $i++) {

            $orderDetail = new OrderDetail();

            $productId= random_int(1,230);
            $product = $manager->getRepository(Product::class)->find($productId);
            $orderDetail->setProducts($product);

            $orderId= random_int(1,99);
            $order = $manager->getRepository(Order::class)->find($orderId);
            $orderDetail->setOrders($order);

            $orderDetail->setQuantity(random_int(1,5));

            $manager->persist($orderDetail);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            ProductFixture::class,
            OrderFixture::class
        ];
    }
}
