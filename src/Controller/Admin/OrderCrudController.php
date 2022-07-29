<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('users', 'Klient'),
            AssociationField::new('deliveries', 'Dostawca'),
            AssociationField::new('orderDetails', 'Zam. Sz. Ilość' )
            ->hideWhenCreating(),
            TextField::new('number', 'Numer zamówienia'),
            DateTimeField::new('created_at', 'Utworzono')
            ->hideWhenCreating(),
            MoneyField::new('total', 'Wartość')
            ->setCurrency('PLN'),
            TextField::new('status', 'Status'),
 
        ];
    }
    
}
