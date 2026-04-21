<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Product\AllergenCrudController;
use App\Controller\Admin\Product\CategoryCrudController;
use App\Controller\Admin\Product\ProductCrudController;
use App\Controller\Admin\Store\OpeningHoursCrudController;
use App\Controller\Admin\Store\StoreCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
//        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        return $this->redirectToRoute('admin_store_index');

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Snapmenu');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkTo(UserCrudController::class, 'Users', 'fas fa-users');
        yield MenuItem::subMenu('fields.store', 'fa fa-store')->setSubItems([
            MenuItem::linkTo(StoreCrudController::class, 'fields.store', 'fas fa-store'),
            MenuItem::linkTo(OpeningHoursCrudController::class, 'fields.opening_hours', 'fas fa-clock'),

        ]);
        yield MenuItem::subMenu('fields.products', 'fa fa-article')->setSubItems([
            MenuItem::linkTo(ProductCrudController::class, 'fields.products', 'fas fa-box')
                ->setAction('index'),
            MenuItem::linkTo(CategoryCrudController::class, 'fields.categories', 'fas fa-box')
                ->setAction('index'),
            MenuItem::linkTo(AllergenCrudController::class, 'fields.allergens', 'fas fa-box')
                ->setAction('index'),
        ]);
    }
}
