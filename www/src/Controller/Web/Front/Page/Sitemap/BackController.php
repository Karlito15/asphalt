<?php

namespace App\Controller\Web\Front\Page\Sitemap;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sitemap', name: 'sitemap.', methods: ['GET'], format: 'xml', utf8: true)]
final class BackController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    )
    {}

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
//    #[Route('/back', name: 'app_back')]
//    public function index(): JsonResponse
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/BackController.php',
//        ]);
//    }
}
