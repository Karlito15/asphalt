<?php

declare(strict_types=1);

namespace App\Application\Controller\EasyAdmin;

use App\Application\Controller\EasyAdmin\Garage\GarageAppCrudController;
use App\Application\Controller\EasyAdmin\Inventory\InventoryAppCrudController;
use App\Application\Controller\EasyAdmin\Mission\MissionAppCrudController;
use App\Application\Controller\EasyAdmin\Mission\TaskCrudController;
use App\Application\Controller\EasyAdmin\Mission\TypeCrudController;
use App\Application\Controller\EasyAdmin\Race\RaceAppCrudController;
use App\Application\Controller\EasyAdmin\Race\ModeCrudController;
use App\Application\Controller\EasyAdmin\Race\RegionCrudController;
use App\Application\Controller\EasyAdmin\Race\SeasonCrudController;
use App\Application\Controller\EasyAdmin\Race\TimeCrudController;
use App\Application\Controller\EasyAdmin\Race\TrackCrudController;
use App\Application\Controller\EasyAdmin\Setting\BlueprintCrudController;
use App\Application\Controller\EasyAdmin\Setting\BrandCrudController;
use App\Application\Controller\EasyAdmin\Setting\ClassCrudController;
use App\Application\Controller\EasyAdmin\Setting\LevelCrudController;
use App\Application\Controller\EasyAdmin\Setting\TagCrudController;
use App\Application\Controller\EasyAdmin\Setting\UnitPriceCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(
    routePath: '/admin',
    routeName: 'admin'
)]
final class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('@App/themes/easy-admin/contents/dashboard/index.html.twig');
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
            MenuItem::linkTo(TaskCrudController::class, 'Tasks', 'fa fa-file-text'),
            MenuItem::linkTo(TypeCrudController::class, 'Types', 'fa fa-file-text'),
            MenuItem::section('Race'),
            MenuItem::linkTo(RaceAppCrudController::class, 'Races', 'fa fa-file-text'),
            MenuItem::linkTo(ModeCrudController::class, 'Modes', 'fa fa-file-text'),
            MenuItem::linkTo(RegionCrudController::class, 'Regions', 'fa fa-file-text'),
            MenuItem::linkTo(SeasonCrudController::class, 'Seasons', 'fa fa-file-text'),
            MenuItem::linkTo(TimeCrudController::class, 'Times', 'fa fa-file-text'),
            MenuItem::linkTo(TrackCrudController::class, 'Tracks', 'fa fa-file-text'),
            MenuItem::section('Setting'),
            MenuItem::linkTo(BlueprintCrudController::class, 'Blueprints', 'fa fa-file-text'),
            MenuItem::linkTo(BrandCrudController::class, 'Brands', 'fa fa-file-text'),
            MenuItem::linkTo(ClassCrudController::class, 'Classes', 'fa fa-file-text'),
            MenuItem::linkTo(LevelCrudController::class, 'Levels', 'fa fa-file-text'),
            MenuItem::linkTo(TagCrudController::class, 'Tags', 'fa fa-file-text'),
            MenuItem::linkTo(UnitPriceCrudController::class, 'Unit-Prices', 'fa fa-file-text'),
        ];
    }
}
