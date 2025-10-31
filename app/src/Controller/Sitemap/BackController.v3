<?php

namespace App\Controller\Back\Page;

use App\Service\Cache\SitemapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sitemap', name: 'sitemap.', schemes: ['http', 'https'], format: 'xml', utf8: true)]
final class SitemapController extends AbstractController
{
    /**
     * @param Request $request
     * @param SitemapService $service
     * @return Response
     */
    #[Route('/back.xml', name: 'back', methods: ['GET'])]
    public function back(Request $request, SitemapService $service): Response
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
        $urls[] = ['loc' => $this->generateUrl('admin.setting.unit-price.index')];
        $urls[] = ['loc' => $this->generateUrl('admin.setting.unit-price.create')];

        // Urls Dynamiques
//        $inventories = $service->cacheCreate()['inventories'];
//        $tasks       = $service->cacheCreate()['tasks'];
//        $types       = $service->cacheCreate()['types'];
//        $modes       = $service->cacheCreate()['modes'];
//        $regions     = $service->cacheCreate()['regions'];
//        $seasons     = $service->cacheCreate()['seasons'];
//        $times       = $service->cacheCreate()['times'];
//        $tracks      = $service->cacheCreate()['tracks'];
//        $blueprints  = $service->cacheCreate()['blueprints'];
//        $brands      = $service->cacheCreate()['brands'];
//        $classes     = $service->cacheCreate()['classes'];
//        $levels      = $service->cacheCreate()['levels'];
//        $tags        = $service->cacheCreate()['tags'];
//        $unitPrices  = $service->cacheCreate()['unitPrices'];
//
//        // Inventories URL
//        foreach ($inventories as $inventory) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.inventory.update', ['id' => $inventory['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.inventory.delete', ['id' => $inventory['id']]),
//            ];
//        }
//        // Missions URL
//        foreach ($tasks as $task) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.mission.task.update', ['id' => $task['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.mission.task.delete', ['id' => $task['id']]),
//            ];
//        }
//        foreach ($types as $type) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.mission.type.update', ['id' => $type['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.mission.type.delete', ['id' => $type['id']]),
//            ];
//        }
//        // Races URL
//        foreach ($modes as $mode) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.race.mode.update', ['id' => $mode['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.race.mode.delete', ['id' => $mode['id']]),
//            ];
//        }
//        foreach ($regions as $region) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.race.region.update', ['id' => $region['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.race.region.delete', ['id' => $region['id']]),
//            ];
//        }
//        foreach ($seasons as $season) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.race.season.update', ['id' => $season['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.race.season.delete', ['id' => $season['id']]),
//            ];
//        }
//        foreach ($times as $time) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.race.time.update', ['id' => $time['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.race.time.delete', ['id' => $time['id']]),
//            ];
//        }
//        foreach ($tracks as $track) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.race.track.update', ['id' => $track['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.race.track.delete', ['id' => $track['id']]),
//            ];
//        }
//        // Settings URL
//        foreach ($blueprints as $blueprint) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.blueprint.update', ['id' => $blueprint['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.blueprint.delete', ['id' => $blueprint['id']]),
//            ];
//        }
//        foreach ($brands as $brand) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.brand.update', ['id' => $brand['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.brand.delete', ['id' => $brand['id']]),
//            ];
//        }
//        foreach ($classes as $class) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.class.update', ['id' => $class['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.class.delete', ['id' => $class['id']]),
//            ];
//        }
//        foreach ($levels as $level) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.level.update', ['id' => $level['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.level.delete', ['id' => $level['id']]),
//            ];
//        }
//        foreach ($tags as $tag) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.tag.update', ['id' => $tag['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.tag.delete', ['id' => $tag['id']]),
//            ];
//        }
//        foreach ($unitPrices as $price) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.unit-price.update', ['id' => $price['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.setting.unit-price.delete', ['id' => $price['id']]),
//            ];
//        }

        // Response
        $response = new Response(
            $this->renderView('@App/share/sitemap.xml.twig', [
                'urls'            => $urls,
                'hostname'        => $hostname,
            ]), Response::HTTP_OK
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
