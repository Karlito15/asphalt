<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin;

use App\Application\Controller\EasyAdmin\Garage\GarageAppCrudController;
use App\Application\Controller\EasyAdmin\Inventory\InventoryAppCrudController;
use App\Application\Controller\EasyAdmin\Mission\MissionAppCrudController;
use App\Application\Controller\EasyAdmin\Mission\MissionTaskCrudController;
use App\Application\Controller\EasyAdmin\Mission\MissionTypeCrudController;
use App\Application\Controller\EasyAdmin\Race\RaceAppCrudController;
use App\Application\Controller\EasyAdmin\Race\RaceModeCrudController;
use App\Application\Controller\EasyAdmin\Race\RaceRegionCrudController;
use App\Application\Controller\EasyAdmin\Race\RaceSeasonCrudController;
use App\Application\Controller\EasyAdmin\Race\RaceTimeCrudController;
use App\Application\Controller\EasyAdmin\Race\RaceTrackCrudController;
use App\Application\Controller\EasyAdmin\Setting\SettingBlueprintCrudController;
use App\Application\Controller\EasyAdmin\Setting\SettingBrandCrudController;
use App\Application\Controller\EasyAdmin\Setting\SettingClassCrudController;
use App\Application\Controller\EasyAdmin\Setting\SettingLevelCrudController;
use App\Application\Controller\EasyAdmin\Setting\SettingTagCrudController;
use App\Application\Controller\EasyAdmin\Setting\SettingUnitPriceCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(
    routePath: '/admin.php',
    routeName: 'easy.admin.app'
)]
final class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');

//        return parent::index();
        return $this->redirectToRoute('easy.admin.app_garage_app_index');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setDefaultColorScheme('dark')
            ->setFaviconPath('favicon/favicon.ico')
            ->setLocales([
                'en' => 'English',
                'fr' => 'Français',
            ])
            ->setTitle('Asphalt Legends')
            ->setTranslationDomain('easy-admin')
            ->setTextDirection('ltr')
            ->renderContentMaximized()
            ->setDefaultColorScheme('dark')
            ->generateRelativeUrls()
        ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa fa-home'),
            MenuItem::section('Apps'),
            MenuItem::linkTo(GarageAppCrudController::class, 'Garages', 'fa fa-tags'),
//            MenuItem::section('Inventory'),
            MenuItem::linkTo(InventoryAppCrudController::class, 'Inventories', 'fa fa-tags'),
            MenuItem::linkTo(MissionAppCrudController::class, 'Missions', 'fa fa-file-text'),
            MenuItem::linkTo(RaceAppCrudController::class, 'Races', 'fa fa-file-text'),
            MenuItem::section('Mission'),
            MenuItem::linkTo(MissionTaskCrudController::class, 'Tasks', 'fa fa-file-text'),
            MenuItem::linkTo(MissionTypeCrudController::class, 'Types', 'fa fa-file-text'),
            MenuItem::section('Race'),
            MenuItem::linkTo(RaceModeCrudController::class, 'Modes', 'fa fa-file-text'),
            MenuItem::linkTo(RaceRegionCrudController::class, 'Regions', 'fa fa-file-text'),
            MenuItem::linkTo(RaceSeasonCrudController::class, 'Seasons', 'fa fa-file-text'),
            MenuItem::linkTo(RaceTimeCrudController::class, 'Times', 'fa fa-file-text'),
            MenuItem::linkTo(RaceTrackCrudController::class, 'Tracks', 'fa fa-file-text'),
            MenuItem::section('Setting'),
            MenuItem::linkTo(SettingBlueprintCrudController::class, 'Blueprints', 'fa fa-file-text'),
            MenuItem::linkTo(SettingBrandCrudController::class, 'Brands', 'fa fa-file-text'),
            MenuItem::linkTo(SettingClassCrudController::class, 'Classes', 'fa fa-file-text'),
            MenuItem::linkTo(SettingLevelCrudController::class, 'Levels', 'fa fa-file-text'),
            MenuItem::linkTo(SettingTagCrudController::class, 'Tags', 'fa fa-file-text'),
            MenuItem::linkTo(SettingUnitPriceCrudController::class, 'Unit-Prices', 'fa fa-file-text'),
        ];
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setPaginatorPageSize(15)
        ;
    }
}
