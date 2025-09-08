<?php

namespace App\Controller\Web\Page;

use App\Repository\AppGarageRepository;
use App\Repository\AppInventoryRepository;
use App\Repository\AppMissionRepository;
use App\Repository\AppRaceRepository;
use App\Repository\MissionTaskRepository;
use App\Repository\MissionTypeRepository;
use App\Repository\RaceModeRepository;
use App\Repository\RaceRegionRepository;
use App\Repository\RaceSeasonRepository;
use App\Repository\RaceTimeRepository;
use App\Repository\RaceTrackRepository;
use App\Repository\SettingBlueprintRepository;
use App\Repository\SettingBrandRepository;
use App\Repository\SettingClassRepository;
use App\Repository\SettingLevelRepository;
use App\Repository\SettingUnitPriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/sitemap', name: 'sitemap.', methods: ['GET'], format: 'xml', utf8: true)]
class SitemapController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    )
    {}

    #[Route('/index.html', name: 'index', format: 'html')]
    public function index(): Response
    {
        $title = $this->translator->trans('controllerName.app.sitemap.index');

        return $this->render('@App/commons/sitemap.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
        ]);
    }

    #[Route('/admin.xml', name: 'admin')]
    public function admin(
        Request $request,
        MissionTaskRepository $task,
        MissionTypeRepository $type,
        RaceModeRepository $mode,
        RaceRegionRepository $region,
        RaceSeasonRepository $season,
        RaceTimeRepository $time,
        RaceTrackRepository $track,
        SettingBlueprintRepository $blueprint,
        SettingBrandRepository $brand,
        SettingClassRepository $class,
        SettingLevelRepository $level,
        SettingUnitPriceRepository $unitprice,
        AppInventoryRepository $inventory,
    ): Response
    {
        // Host
        $hostname = $request->getSchemeAndHttpHost();

        // Results
        $urls   = [];

        // Urls Statiques
        $urls[] = ['loc' => $this->generateUrl('admin.inventory.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.inventory.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.mission.task.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.mission.task.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.mission.type.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.mission.type.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.race.mode.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.race.mode.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.race.region.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.race.region.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.race.season.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.race.season.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.race.time.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.race.time.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.race.track.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.race.track.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.setting.blueprint.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.setting.blueprint.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.setting.brand.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.setting.brand.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.setting.class.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.setting.class.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.setting.level.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.setting.level.create')];
        $urls[] = ['loc' => $this->generateUrl('admin.setting.unitprice.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.setting.unitprice.create')];

        // Urls Dynamiques
        $inventories = $inventory->findAll();
        $tasks       = $task->findAll();
        $types       = $type->findAll();
        $modes       = $mode->findAll();
        $regions     = $region->findAll();
        $seasons     = $season->findAll();
        $times       = $time->findAll();
        $tracks      = $track->findAll();
        $blueprints  = $blueprint->findAll();
        $brands      = $brand->findAll();
        $classes     = $class->findAll();
        $levels      = $level->findAll();
        $prices      = $unitprice->findAll();

        // Inventories URL
        foreach ($inventories as $inventory) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.inventory.update', ['id' => $inventory->getId(), 'slug' => $inventory->getSlug()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.inventory.delete', ['id' => $inventory->getId()]),
            ];
        }
        // Missions URL
        foreach ($tasks as $task) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.mission.task.update', ['id' => $task->getId(), 'slug' => $inventory->getSlug()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.mission.task.delete', ['id' => $task->getId()]),
            ];
        }
        foreach ($types as $type) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.mission.type.update', ['id' => $type->getId()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.mission.type.delete', ['id' => $type->getId()]),
            ];
        }
        // Races URL
        foreach ($modes as $mode) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.race.mode.update', ['id' => $mode->getId(), 'slug' => $inventory->getSlug()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.race.mode.delete', ['id' => $mode->getId()]),
            ];
        }
        foreach ($regions as $region) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.race.region.update', ['id' => $region->getId(), 'slug' => $inventory->getSlug()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.race.region.delete', ['id' => $region->getId()]),
            ];
        }
        foreach ($seasons as $season) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.race.season.update', ['id' => $season->getId(), 'slug' => $inventory->getSlug()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.race.season.delete', ['id' => $season->getId()]),
            ];
        }
        foreach ($times as $time) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.race.time.update', ['id' => $time->getId()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.race.time.delete', ['id' => $time->getId()]),
            ];
        }
        foreach ($tracks as $track) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.race.track.update', ['id' => $track->getId(), 'slug' => $inventory->getSlug()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.race.track.delete', ['id' => $track->getId()]),
            ];
        }
        // Settings URL
        foreach ($blueprints as $blueprint) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.setting.blueprint.update', ['id' => $blueprint->getId()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.setting.blueprint.delete', ['id' => $blueprint->getId()]),
            ];
        }
        foreach ($brands as $brand) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.setting.brand.update', ['id' => $brand->getId(), 'slug' => $inventory->getSlug()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.setting.brand.delete', ['id' => $brand->getId()]),
            ];
        }
        foreach ($classes as $class) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.setting.class.update', ['id' => $class->getId(), 'slug' => $inventory->getSlug()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.setting.class.delete', ['id' => $class->getId()]),
            ];
        }
        foreach ($levels as $level) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.setting.level.update', ['id' => $level->getId()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.setting.level.delete', ['id' => $level->getId()]),
            ];
        }
        foreach ($prices as $price) {
            $urls[] = [
                'loc' => $this->generateUrl('admin.setting.unitprice.update', ['id' => $price->getId(), 'slug' => $inventory->getSlug()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('admin.setting.unitprice.delete', ['id' => $price->getId()]),
            ];
        }

        // Response
        $response = new Response(
            $this->renderView('@App/commons/sitemap.xml.twig', [
                'urls'            => $urls,
                'hostname'        => $hostname,
            ]), Response::HTTP_OK
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }

    #[Route('/api.xml', name: 'api')]
    public function api(Request $request): Response
    {
        // Host
        $hostname = $request->getSchemeAndHttpHost();

        // Results
        $urls   = [];

        // Urls Statiques
        $urls[] = ['loc' => $this->generateUrl('app.dashboard.index')];

        // Response
        $response = new Response(
            $this->renderView('@App/commons/sitemap.xml.twig', [
                'urls'            => $urls,
                'hostname'        => $hostname,
            ]), Response::HTTP_OK
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }

    #[Route('/app.xml', name: 'app')]
    public function app(
        Request $request,
        AppGarageRepository $garage,
        AppMissionRepository $mission,
        AppRaceRepository $race,
    ): Response
    {
        // Host
        $hostname = $request->getSchemeAndHttpHost();

        // Results
        $urls   = [];

        // Urls Statiques
        $urls[] = ['loc' => $this->generateUrl('app.dashboard.index')];
        $urls[] = ['loc' => $this->generateUrl('app.garage.index')];
        $urls[] = ['loc' => $this->generateUrl('app.garage.create')];
        $urls[] = ['loc' => $this->generateUrl('app.mission.index')];
        $urls[] = ['loc' => $this->generateUrl('app.mission.create')];
        $urls[] = ['loc' => $this->generateUrl('app.race.index')];
        $urls[] = ['loc' => $this->generateUrl('app.race.create')];

        // Urls Dynamiques
        $garages  = $garage->findAll();
        $missions = $mission->findAll();
        $races    = $race->findAll();

        // Garages URL
        foreach ($garages as $garage) {
            $urls[] = [
                'loc' => $this->generateUrl('app.garage.update', ['id' => $garage->getId(), 'slug' => $garage->getSlug()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.garage.delete', ['id' => $garage->getId()]),
            ];
        }
        foreach ($missions as $mission) {
            $urls[] = [
                'loc' => $this->generateUrl('app.mission.update', ['id' => $mission->getId()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.mission.delete', ['id' => $mission->getId()]),
            ];
        }
        foreach ($races as $race) {
            $urls[] = [
                'loc' => $this->generateUrl('app.race.update', ['id' => $race->getId(), 'slug' => $race->getSlug()]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.race.delete', ['id' => $race->getId()]),
            ];
        }

        // Response
        $response = new Response(
            $this->renderView('@App/commons/sitemap.xml.twig', [
                'urls'            => $urls,
                'hostname'        => $hostname,
            ]), Response::HTTP_OK
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
