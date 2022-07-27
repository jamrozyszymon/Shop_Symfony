<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;


class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nazwa'),
            TextField::new('code', 'Kod'),
            TextEditorField::new('content', 'Opis'),
            AssociationField::new('categories', 'Kategoria'),
            MoneyField::new('price', 'Cena')
            ->setCurrency('PLN'),
            IntegerField::new('discount', 'Zniżka'),
            IntegerField::new('quantity', 'Ilość'),

        ];
    }
}
