<?php

namespace App\Controller\Admin;

use App\Persistence\Entity\MissionApp;
use App\Persistence\Entity\MissionTask;
use App\Persistence\Entity\MissionType;
use App\Persistence\Entity\RaceMode;
use App\Persistence\Entity\RaceRegion;
use App\Persistence\Entity\RaceSeason;
use App\Persistence\Entity\RaceTime;
use App\Persistence\Entity\RaceTrack;
use App\Persistence\Entity\SettingBlueprint;
use App\Persistence\Entity\SettingBrand;
use App\Persistence\Entity\SettingClass;
use App\Persistence\Entity\SettingLevel;
use App\Persistence\Entity\SettingTag;
use App\Persistence\Entity\SettingUnitPrice;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin/{_locale}', name: 'admin')]
    public function index(): Response
    {
        return parent::index();

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
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('App')
            ->setTranslationDomain('admin')
            ->setTextDirection('ltr')
            ->renderContentMaximized()
            ->setDefaultColorScheme('dark')
            ->generateRelativeUrls()
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-regular fa-floppy-disk');
        yield MenuItem::section('Mission');
        yield MenuItem::linkToCrud('App', 'fa fa-home', MissionApp::class);
        yield MenuItem::linkToCrud('Task', 'fa fa-home', MissionTask::class);
        yield MenuItem::linkToCrud('Type', 'fa fa-home', MissionType::class);
        yield MenuItem::section('Race');
        yield MenuItem::linkToCrud('Mode', 'fa fa-solid fa-1', RaceMode::class);
        yield MenuItem::linkToCrud('Region', 'fa-solid fa-2', RaceRegion::class);
        yield MenuItem::linkToCrud('Season', 'fa-solid fa-3', RaceSeason::class);
        yield MenuItem::linkToCrud('Time', 'fa-solid fa-4', RaceTime::class);
        yield MenuItem::linkToCrud('Track', 'fa-solid fa-5', RaceTrack::class);
        yield MenuItem::section('Setting');
        yield MenuItem::linkToCrud('Blueprint', 'fa fa-home', SettingBlueprint::class);
        yield MenuItem::linkToCrud('Brand', 'fa fa-home', SettingBrand::class);
        yield MenuItem::linkToCrud('Class', 'fa fa-home', SettingClass::class);
        yield MenuItem::linkToCrud('Level', 'fa fa-home', SettingLevel::class);
        yield MenuItem::linkToCrud('Tag', 'fa fa-home', SettingTag::class);
        yield MenuItem::linkToCrud('Unit-Price', 'fa fa-home', SettingUnitPrice::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setPaginatorPageSize(18)
        ;
    }


}
