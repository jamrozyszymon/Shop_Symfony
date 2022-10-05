<?php

namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\OrderDetail;


class OrderDetailRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testfindTopSalesProducts()
    {
        $topProducts = $this->entityManager
            ->getRepository(OrderDetail::class)
            ->findTopSalesProducts(100,12);

        $this->assertIsArray($topProducts);
        $this->assertCount(1, $topProducts);
        $this->assertSame(
            array(
                "products_id" => 1,
                "num_pr" => "43"
            ), 
            $topProducts[0]);
    }
    



}
