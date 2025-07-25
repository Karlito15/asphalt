<?php

namespace App\Controller\Web\Front\Page\Sitemap;

use App\Service\Cache\SitemapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sitemap', name: 'sitemap.', schemes: ['http', 'https'], format: 'html', utf8: true)]
final class BackController extends AbstractController
{
    #[Route('/back.xml', name: 'back', methods: ['GET'])]
    public function admin(
        Request         $request,
        SitemapService  $service,
    ): Response
    {
        // Host
        $hostname = $request->getSchemeAndHttpHost();

        // Results
        $urls   = [];

        // Urls Statiques
        $urls[] = ['loc' => $this->generateUrl('app.inventory.index')];
        $urls[] = ['loc' => $this->generateUrl('app.inventory.create')];
        $urls[] = ['loc' => $this->generateUrl('app.mission.task.index')];
        $urls[] = ['loc' => $this->generateUrl('app.mission.task.create')];
        $urls[] = ['loc' => $this->generateUrl('app.mission.type.index')];
        $urls[] = ['loc' => $this->generateUrl('app.mission.type.create')];
        $urls[] = ['loc' => $this->generateUrl('app.race.mode.index')];
        $urls[] = ['loc' => $this->generateUrl('app.race.mode.create')];
        $urls[] = ['loc' => $this->generateUrl('app.race.region.index')];
        $urls[] = ['loc' => $this->generateUrl('app.race.region.create')];
        $urls[] = ['loc' => $this->generateUrl('app.race.season.index')];
        $urls[] = ['loc' => $this->generateUrl('app.race.season.create')];
        $urls[] = ['loc' => $this->generateUrl('app.race.time.index')];
        $urls[] = ['loc' => $this->generateUrl('app.race.time.create')];
        $urls[] = ['loc' => $this->generateUrl('app.race.track.index')];
        $urls[] = ['loc' => $this->generateUrl('app.race.track.create')];
        $urls[] = ['loc' => $this->generateUrl('app.setting.blueprint.index')];
        $urls[] = ['loc' => $this->generateUrl('app.setting.blueprint.create')];
        $urls[] = ['loc' => $this->generateUrl('app.setting.brand.index')];
        $urls[] = ['loc' => $this->generateUrl('app.setting.brand.create')];
        $urls[] = ['loc' => $this->generateUrl('app.setting.class.index')];
        $urls[] = ['loc' => $this->generateUrl('app.setting.class.create')];
        $urls[] = ['loc' => $this->generateUrl('app.setting.level.index')];
        $urls[] = ['loc' => $this->generateUrl('app.setting.level.create')];
        $urls[] = ['loc' => $this->generateUrl('app.setting.unit-price.index')];
        $urls[] = ['loc' => $this->generateUrl('app.setting.unit-price.create')];

        // Urls Dynamiques
        $inventories = $service->cacheCreate()['inventories'];
        $tasks       = $service->cacheCreate()['tasks'];
        $types       = $service->cacheCreate()['types'];
        $modes       = $service->cacheCreate()['modes'];
        $regions     = $service->cacheCreate()['regions'];
        $seasons     = $service->cacheCreate()['seasons'];
        $times       = $service->cacheCreate()['times'];
        $tracks      = $service->cacheCreate()['tracks'];
        $blueprints  = $service->cacheCreate()['blueprints'];
        $brands      = $service->cacheCreate()['brands'];
        $classes     = $service->cacheCreate()['classes'];
        $levels      = $service->cacheCreate()['levels'];
        $tags        = $service->cacheCreate()['tags'];
        $unitPrices  = $service->cacheCreate()['unitPrices'];

        // Inventories URL
        foreach ($inventories as $inventory) {
            $urls[] = [
                'loc' => $this->generateUrl('app.inventory.update', ['id' => $inventory['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.inventory.delete', ['id' => $inventory['id']]),
            ];
        }
        // Missions URL
        foreach ($tasks as $task) {
            $urls[] = [
                'loc' => $this->generateUrl('app.mission.task.update', ['id' => $task['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.mission.task.delete', ['id' => $task['id']]),
            ];
        }
        foreach ($types as $type) {
            $urls[] = [
                'loc' => $this->generateUrl('app.mission.type.update', ['id' => $type['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.mission.type.delete', ['id' => $type['id']]),
            ];
        }
        // Races URL
        foreach ($modes as $mode) {
            $urls[] = [
                'loc' => $this->generateUrl('app.race.mode.update', ['id' => $mode['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.race.mode.delete', ['id' => $mode['id']]),
            ];
        }
        foreach ($regions as $region) {
            $urls[] = [
                'loc' => $this->generateUrl('app.race.region.update', ['id' => $region['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.race.region.delete', ['id' => $region['id']]),
            ];
        }
        foreach ($seasons as $season) {
            $urls[] = [
                'loc' => $this->generateUrl('app.race.season.update', ['id' => $season['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.race.season.delete', ['id' => $season['id']]),
            ];
        }
        foreach ($times as $time) {
            $urls[] = [
                'loc' => $this->generateUrl('app.race.time.update', ['id' => $time['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.race.time.delete', ['id' => $time['id']]),
            ];
        }
        foreach ($tracks as $track) {
            $urls[] = [
                'loc' => $this->generateUrl('app.race.track.update', ['id' => $track['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.race.track.delete', ['id' => $track['id']]),
            ];
        }
        // Settings URL
        foreach ($blueprints as $blueprint) {
            $urls[] = [
                'loc' => $this->generateUrl('app.setting.blueprint.update', ['id' => $blueprint['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.setting.blueprint.delete', ['id' => $blueprint['id']]),
            ];
        }
        foreach ($brands as $brand) {
            $urls[] = [
                'loc' => $this->generateUrl('app.setting.brand.update', ['id' => $brand['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.setting.brand.delete', ['id' => $brand['id']]),
            ];
        }
        foreach ($classes as $class) {
            $urls[] = [
                'loc' => $this->generateUrl('app.setting.class.update', ['id' => $class['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.setting.class.delete', ['id' => $class['id']]),
            ];
        }
        foreach ($levels as $level) {
            $urls[] = [
                'loc' => $this->generateUrl('app.setting.level.update', ['id' => $level['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.setting.level.delete', ['id' => $level['id']]),
            ];
        }
        foreach ($tags as $tag) {
            $urls[] = [
                'loc' => $this->generateUrl('app.setting.tag.update', ['id' => $tag['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.setting.tag.delete', ['id' => $tag['id']]),
            ];
        }
        foreach ($unitPrices as $price) {
            $urls[] = [
                'loc' => $this->generateUrl('app.setting.unit-price.update', ['id' => $price['id']]),
            ];
                $urls[] = [
                'loc' => $this->generateUrl('app.setting.unit-price.delete', ['id' => $price['id']]),
            ];
        }

        // Response
        $response = new Response(
            $this->renderView('@App/contents/commons/sitemap.xml.twig', [
                'urls'            => $urls,
                'hostname'        => $hostname,
            ]), Response::HTTP_OK
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
