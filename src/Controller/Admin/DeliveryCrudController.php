<?php

namespace App\Controller\Admin;

use App\Entity\Delivery;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DeliveryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Delivery::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nazwa'),
            TextField::new('type', 'Rodzaj'),
            MoneyField::new('price', 'Koszt')
            ->setCurrency('PLN'),
            AssociationField::new('orders', 'Liczba zamówień')
            ->hideWhenCreating(),
        ];
    }
}
