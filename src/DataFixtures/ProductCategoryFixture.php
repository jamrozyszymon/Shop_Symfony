<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ProductCategory;

class ProductCategoryFixture extends Fixture
{
    private $dataDesc = array(
        'Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        'It is a long established fact that a reader will be distracted by the readable content of a page'
    );

    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<35; $i++) {
        $category = new ProductCategory();
                
        $randomDesc = $this->dataDesc[array_rand($this->dataDesc, 1)];
        $category->setDescription($randomDesc);

            if($i<10) {
                $category->setName('Kategoria '.$i);
                $category->setCode('00'.$i);
                $category->setParent(null);
            } else {
                $category->setName('Podkategoria '.$i);

                $categoryParentId = random_int(1,9);

                $category->setCode('00'.$categoryParentId.'/0'.$i);

                $categoryParent = $manager->getRepository(ProductCategory::class)->find($categoryParentId);
                $category->setParent($categoryParent);
            }

        $manager->persist($category);
        $manager->flush();
        }
    }
}
