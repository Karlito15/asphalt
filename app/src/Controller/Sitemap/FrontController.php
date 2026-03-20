<?php

declare(strict_types=1);

namespace App\Controller\Sitemap;

use App\Service\Cache\SitemapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/sitemap',
    name: 'sitemap.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'xml', // html
    utf8: true
)]
final class FrontController extends AbstractController
{
    #[Route('/front.xml', name: 'front')]
    public function index(
        Request $request,
        SitemapService $service,
    ): Response
    {
        ### Headers
        $request->headers->set('Content-Type', 'text/xml');
//        $headers = $request->headers->all();

        ### Host
        $hostname = $request->getSchemeAndHttpHost();

        ### Results
        $urls     = [];

        ### Urls Statiques
        $urls[]   = ['loc' => $this->generateUrl('app.dashboard.index')];

        ### Urls Dynamiques
        $garages  = $service->cacheCreate()['garages'];
//        $inventories = $service->cacheCreate();
//        $missions = $service->cacheCreate()['missions'];
//        $races    = $service->cacheCreate()['races'];

        ### Loops
        foreach ($garages as $garage) {
            $urls[] = [
                'loc' => $this->generateUrl('app.garage.read', ['id' => $garage['id'], 'slug' => $garage['slug']]),
            ];
            $urls[] = [
                'loc' => $this->generateUrl('app.garage.update', ['id' => $garage['id'], 'slug' => $garage['slug']]),
            ];
            $urls[] = [
                'loc' => $this->generateUrl('app.garage.delete', ['id' => $garage['id']]),
            ];
        }
//        foreach ($inventories as $inventory) {
//            $urls[] = [
//                'loc' => $this->generateUrl('admin.inventory.app.update', ['id' => $inventory['id']]),
//            ];
//                $urls[] = [
//                'loc' => $this->generateUrl('admin.inventory.app.delete', ['id' => $inventory['id']]),
//            ];
//        }
//        foreach ($missions as $mission) {
//            $urls[] = [
//                'loc' => $this->generateUrl('app.mission.index', ['id' => $mission['id']]),
//            ];
//        }
//        foreach ($races as $race) {
//            $urls[] = [
//                'loc' => $this->generateUrl('app.race.index', ['id' => $race['id']]),
//            ];
//        }

        ### Response
        return new Response(
            $this->renderView('@App/contents/sitemap/index.xml.twig', [
                'controller_name' => 'Front',
                'urls'            => $urls,
                'hostname'        => $hostname,
            ]), Response::HTTP_OK
        );
    }
}
