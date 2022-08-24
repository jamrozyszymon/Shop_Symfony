<?php

namespace App\Tests\Controller;

use Symfony\Component\BrowserKit\AbstractBrowser;

/**
 * Simulate adding product to cart
 */
class CartSimulateProduct
{
    /**
     * Prepare product
     */
    public function createProduct(AbstractBrowser $client): array
    {
        $crawler = $client->request('GET', '/product-list/category/podkategoria-i,3/1');
        $productNode = $crawler->filter('.card')->eq(0);
        $productName = $crawler->filter('.card-body > a > h3')->getNode(0)->textContent;
        $productPrice = (float)$productNode->filter('div.product-cart-body-info > div:nth-child(1) > h5')->getNode(0)->textContent;
        $productLink = $productNode->filter('.btn-secondary')->link();

        return [
            'name' => $productName,
            'price' => $productPrice,
            'url' => $productLink->getUri()
        ];
    
    }

    /**
     * Adding simulated product to cart
     */
    public function addProduct(AbstractBrowser $client): array
    {
        $product = $this->createProduct($client);
        $crawler = $client->request('GET', $product['url']);

        $form = $crawler->filter('.g-3')->form();
        $form->setValues(['add_to_cart_form[quantity]' => 1]);
        $client->submit($form);

        return $product;
    }
}