<?php

namespace App\Controller\Admin;

use App\Entity\OrderDetail;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class OrderDetailCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderDetail::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
            ->hideWhenCreating(),
            AssociationField::new('products', 'Produkt'),
            AssociationField::new('orders','ID zamówienia'),
            IntegerField::new('quantity', 'Ilość'),
        ];
    }

}
