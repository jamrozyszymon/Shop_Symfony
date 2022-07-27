<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CustomerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email', 'E-mail'),
            TextField::new('firstname', 'Imię'),
            TextField::new('lastname', 'Nazwisko'),
            AssociationField::new('orders', 'Liczba zamówień'),
        ];
    }

}
