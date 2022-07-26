<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use DateTime;
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
            AssociationField::new('customers'),
            AssociationField::new('employees'),
            DateTimeField::new('created_at'),
            MoneyField::new('total')
            ->setCurrency('PLN'),
            TextField::new('status'),
 
        ];
    }
    
}
