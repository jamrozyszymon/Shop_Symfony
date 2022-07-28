<?php

namespace App\Controller\Admin;

use App\Entity\ProductCategory;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\Customer;
use App\Entity\OrderDetail;
use App\Entity\Delivery;
use App\Entity\O;
use App\Entity\OD;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     * 
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        //return parent::index();

         // Option 1. Make your dashboard redirect to the same page for all Customers
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(OrderCrudController::class)->generateUrl());

        /*
        Option 2. You can make your dashboard redirect to different pages depending on the Customer
        
        if ('jane' === $this->getCustomer()->getCustomername()) {
            return $this->redirect('...');
        }

        Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        */

        return $this->render('home.html.twig');
        

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Panel Administratora');
    }

    public function configureMenuItems(): iterable
    {   
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Zamówienia'),
            MenuItem::linkToCrud('Zamówienia', 'fa fa-tags', Order::class),
            MenuItem::linkToCrud('Zamówienia Szczegóły', 'fa fa-tags', OrderDetail::class),

            MenuItem::section('Produkty'),
            MenuItem::linkToCrud('Kategorie', 'fa fa-tags', ProductCategory::class),
            MenuItem::linkToCrud('Produkty', 'fa fa-tags', Product::class),

            MenuItem::section('Klienci'),
            MenuItem::linkToCrud('Klienci', 'fa fa-tags', Customer::class),

            MenuItem::section('Dostawcy'),
            MenuItem::linkToCrud('Dostawcy', 'fa fa-tags', Delivery::class),

        ];
    }
}
