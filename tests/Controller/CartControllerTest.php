<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Controller\CartSimulateProduct;

class CartControllerTest extends WebTestCase
{
    public function testIsCartOpen(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Koszyk');
    }

    public function testIsEmptyCartDisplayCorrect(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart');

        $text= $crawler->filter('body > div.container > main > article > div > h5')
            ->getNode(0)
            ->textContent;
        
        $this->assertEquals('Twój koszyk jest pusty', $text);
    }

    public function testAddProductToCart()
    {
        $cartSimulateProduct = new CartSimulateProduct();
        
        $client = static::createClient();
        $product = $cartSimulateProduct->addProduct($client);
        $crawler = $client->request('GET', '/cart');

        $header= $crawler->filter('body > div.container > main > article > form > div > div > div.row.no-gutters > div.col-md-8 > h2')
            ->getNode(0)
            ->textContent;
        
        $productName= $crawler->filter('div.col-md-5 > div > a > h5')
            ->getNode(0)
            ->textContent;
        
        $amountDisplayProducts= $crawler->filter('body > div.container > main > article > form > div > div > div:nth-child(3)')
            ->count();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Twój koszyk', $header);
        $this->assertStringContainsString($product['name'], $productName);
        $this->assertEquals(1, $amountDisplayProducts);

    }

    public function testRemoveProduct()
    {

        $cartSimulateProduct = new CartSimulateProduct();
        
        $client = static::createClient();
        $product = $cartSimulateProduct->addProduct($client);
        $crawler = $client->request('GET', '/cart');

        $amountProductBeforeDelete= $crawler->filter('body > div.container > main > article > form > div > div > div:nth-child(3)')
        ->count();

        $crawler=$client->submitForm('Usuń');
        $crawler = $client->followRedirect();

        $amountProductAfterDelete= $crawler->filter('body > div.container > main > article > form > div > div > div:nth-child(3)')
        ->count();

        $this->assertGreaterThan($amountProductAfterDelete, $amountProductBeforeDelete);
    }

    public function testRedirectAfterRemoveAllProduct()
    {

        $cartSimulateProduct = new CartSimulateProduct();
        
        $client = static::createClient();
        $product = $cartSimulateProduct->addProduct($client);
        $crawler = $client->request('GET', '/cart');

        $crawler=$client->submitForm('Opróżnij koszyk');
        $crawler = $client->followRedirect();

        $text= $crawler->filter('body > div.container > main > article > div > h5')
        ->getNode(0)
        ->textContent;
    
         $this->assertEquals('Twój koszyk jest pusty', $text);
    }


}