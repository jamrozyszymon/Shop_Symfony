<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<100; $i++){
            $order = new Order();

            $userId = random_int(1,25);
            $user = $manager->getRepository(User::class)->find($userId);
            $order->setUsers($user);

            $order->setCreatedAtFixture($this->randomTime(new DateTime("2022-05-01"), new DateTime("now")));

            $order->setStatus('cart');

            $manager->persist($order);
            $manager->flush();
        }
    }

    public function randomTime(DateTime $start, DateTime $end) 
    {
        $random = mt_rand($start->getTimestamp(), $end->getTimestamp());
        $randomDate = new DateTime();
        $randomDate->setTimestamp($random);
        return $randomDate;

    }

    public function getDependencies()
    {
        return [
            UserFixture::class
        ];
    }

}
