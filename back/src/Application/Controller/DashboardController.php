<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Controller\Garage\GarageAppCrudController;
use App\Application\Controller\Inventory\InventoryAppCrudController;
use App\Application\Controller\Mission\MissionAppCrudController;
use App\Application\Controller\Mission\MissionTaskCrudController;
use App\Application\Controller\Mission\MissionTypeCrudController;
use App\Application\Controller\Race\RaceAppCrudController;
use App\Application\Controller\Race\RaceModeCrudController;
use App\Application\Controller\Race\RaceRegionCrudController;
use App\Application\Controller\Race\RaceSeasonCrudController;
use App\Application\Controller\Race\RaceTimeCrudController;
use App\Application\Controller\Race\RaceTrackCrudController;
use App\Application\Controller\Setting\SettingBlueprintCrudController;
use App\Application\Controller\Setting\SettingBrandCrudController;
use App\Application\Controller\Setting\SettingClassCrudController;
use App\Application\Controller\Setting\SettingLevelCrudController;
use App\Application\Controller\Setting\SettingTagCrudController;
use App\Application\Controller\Setting\SettingUnitPriceCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(
//    routePath: '/admin/dashboard.php',
    routePath: '/',
    routeName: 'admin.dashboard.index',
    routeOptions: ['method' => 'GET']
)]
final class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('@App/contents/dashboard/index.html.twig');
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
            // ->renderContentMaximized()
            ->setDefaultColorScheme('dark')
            ->generateRelativeUrls()
        ;
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setPaginatorPageSize(15)
        ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa fa-home'),
            MenuItem::section('Apps'),
            MenuItem::linkTo(GarageAppCrudController::class, 'Garages', 'fa fa-tags'),
            MenuItem::section('Inventory'),
            MenuItem::linkTo(InventoryAppCrudController::class, 'Inventories', 'fa fa-tags'),
            MenuItem::section('Mission'),
            MenuItem::linkTo(MissionAppCrudController::class, 'Missions', 'fa fa-file-text'),
            MenuItem::linkTo(MissionTaskCrudController::class, 'Tasks', 'fa fa-file-text'),
            MenuItem::linkTo(MissionTypeCrudController::class, 'Types', 'fa fa-file-text'),
            MenuItem::section('Race'),
            MenuItem::linkTo(RaceAppCrudController::class, 'Races', 'fa fa-file-text'),
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
}
