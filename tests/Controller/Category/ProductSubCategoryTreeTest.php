<?php

namespace App\Tests\Controller\Category;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Twig\SluggExtension;
use App\Controller\Category\ProductSubCategoryTree;

class ProductSubCategoryTreeTest extends KernelTestCase
{
    public $mockedProductSubCategoryTree;

    public function setUp(): void
    {

        self::bootKernel();
        $container = static::getContainer();
        $urlGenerator = $container->get('router');

        $this->mockedProductSubCategoryTree = $this->getMockBuilder('App\Controller\Category\ProductSubCategoryTree')
         ->disableOriginalConstructor()
         ->onlyMethods([]) // if no, all methods return null unless mocked
         ->getMock();

         $this->mockedProductSubCategoryTree->urlGenerator = $urlGenerator;
    }

    /**
     * @dataProvider dataForSubCategoryTree
     */
    public function testIsGetCategoriesListMethodReturnNestedList($resultString, $array)
    {

        $this->mockedProductSubCategoryTree->allCategories = $array;
        $array = $this->mockedProductSubCategoryTree->buildTree();
        
        $this->assertSame(
            $resultString, 
            $this->mockedProductSubCategoryTree->getCategoriesList($array));

    }


    public function dataForSubCategoryTree()
    {
        yield [
            '<ul><li>Kategoria 1<ul><li><a href="/product-list/category/podkategoria-i,3">Podkategoria I</a></li></ul></li><li>Kategoria 3</li></ul>',
        [
            ['id' => 1, 'name' => 'Kategoria 1', 'parent_id' => null],
            ['id' => 3, 'name' => 'Podkategoria I', 'parent_id' => 1],
            ['id' => 12, 'name' => 'Kategoria 3', 'parent_id' => null]
        ]
        ];
    }

}