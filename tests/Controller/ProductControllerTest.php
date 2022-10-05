<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testProductList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/product-list/category/podkategoria-i,3/1');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Podkategoria i');
    }

    public function testProductSearchList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/product-list/1?searchby=Produkt+12');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Wyniki dla wyszukiwania: "Produkt 12');
    }

    public function testProductSearchButtonWhenNotFound(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $buttonCrawlerNode = $crawler->selectButton('Szukaj');
        $form = $buttonCrawlerNode->form();
        $form['searchby']='not found';

        $client->submit($form);

        $this->assertSelectorTextContains('h2', 'Brak wyników wyszukiwania dla:');
    }

    public function testProductSearchButtonWhenFound(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $buttonCrawlerNode = $crawler->selectButton('Szukaj');
        $form = $buttonCrawlerNode->form();
        $form['searchby']='Produkt 12';
        $client->submit($form);

        $this->assertSelectorTextContains('h2', 'Wyniki dla wyszukiwania: "Produkt 12');
    }

    public function testDisplayProductTopList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Najchętniej kupowane');
    }
}
