<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\ProductCategory;

class ProductCategoryControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        $client = static::createClient();
    }

    public function testSomething(): void
    {

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');
    }
}
