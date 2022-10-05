<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use App\Entity\ProductCategory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ProductFixture extends Fixture implements DependentFixtureInterface
{
    private $dataName = array(
        'AProdukt ',
        'ABCProdukt ',
        'XYZProdukt ',
        'IJKProdukt '
    );

    private $dataPrice = array(
        9.99,
        19.99,
        99.99,
        159.00,
        699.00
    );

    private $dataDesc = array(
        'Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        'It is a long established fact that a reader will be distracted by the readable content of a page'
    );

    private $dataDisc = array(
        0.05,
        0.1,
        0.2,
        0.5
    );

    private $dataImg = array(
        'img1.jpg',
        'img2.jpg'
    );

    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<250; $i++) {
            $product = new Product();
            
            $subcategoryId= random_int(10,34);
            $subcategory = $manager->getRepository(ProductCategory::class)->find($subcategoryId);
            $product->setCategories($subcategory);

            $randomName = $this->dataName[array_rand($this->dataName, 1)];
            $product->setName($randomName.$i);

            if($i<10) {
                $product->setCode('0000'.$i);
            } elseif($i>=10 && $i<100) {
                $product->setCode('000'.$i);
            } else {
                $product->setCode('00'.$i);
            }

            $randomPrice = $this->dataPrice[array_rand($this->dataPrice, 1)];
            $product->setPrice($randomPrice);

            $randomDesc = $this->dataDesc[array_rand($this->dataDesc, 1)];
            $product->setContent($randomDesc);

            $randomDisc = $this->dataDisc[array_rand($this->dataDisc, 1)];
            $product->setDiscount($randomDisc);

            $product->setQuantity(random_int(1,999));

            $randomImg = $this->dataImg[array_rand($this->dataImg, 1)];
            $product->setImagesFileName($randomImg);

            $manager->persist($product);
            $manager->flush();
        }
        
    }

    public function getDependencies()
    {
        return [
            ProductCategoryFixture::class
        ];
    }
}
