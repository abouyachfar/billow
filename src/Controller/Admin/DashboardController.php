<?php

namespace App\Controller\Admin;

use App\Entity\BuyPage;
use App\Entity\City;
use App\Entity\Faq;
use App\Entity\Pack;
use App\Entity\PackOptions;
use App\Entity\Payment;
use App\Entity\Property;
use App\Entity\PropertyType;
use App\Entity\Region;
use App\Entity\SellPage;
use App\Entity\SiteParams;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Billow Admin')
            ->disableUrlSignatures()
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Web Site (www.billow.ca)', 'fa fa-home', 'http://www.billow.ca');
        yield MenuItem::section("Business");
        yield MenuItem::linkToCrud('Manage Properties', 'fa fa-building', Property::class);
        yield MenuItem::linkToRoute('Manage Featured Homes', 'fa fa-building', 'app_admin_featured_homes')->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Manage Users', 'fa fa-user-cog', User::class);
        yield MenuItem::linkToCrud('Manage Payments', 'fa fa-cash-register', Payment::class);
        yield MenuItem::section("Configurations");
        yield MenuItem::linkToCrud('Manage Packs', 'fa fa-archive', Pack::class);
        yield MenuItem::linkToCrud('Manage Pack Options', 'fa fa-bullseye', PackOptions::class);
        yield MenuItem::linkToCrud('Manage Regions', 'fa fa-map-signs', Region::class);
        yield MenuItem::linkToCrud('Manage Cities', 'fa fa-map-marker', City::class);
        yield MenuItem::section("CMS");
        yield MenuItem::linkToCrud('Manage FAQ Pages', 'fa fa-question-circle-o', Faq::class);
        yield MenuItem::linkToCrud('Manage Buy Pages', 'fa fa-book', BuyPage::class);
        yield MenuItem::linkToCrud('Manage Sell Pages', 'fa fa-book', SellPage::class);
        yield MenuItem::section("Exit");
        yield MenuItem::linkToLogout('Logout', 'fas fa-sign-out-alt');
    }
}
