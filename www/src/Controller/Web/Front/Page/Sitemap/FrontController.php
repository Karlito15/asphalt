<?php

namespace App\Controller\Web\Front\Page\Sitemap;

use App\Service\Cache\SitemapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sitemap', name: 'sitemap.', schemes: ['http', 'https'], format: 'xml', utf8: true)]
final class FrontController extends AbstractController
{
    /**
     * @param Request $request
     * @param SitemapService $service
     * @return Response
     */
    #[Route('/front.xml', name: 'front', methods: ['GET'])]
    public function app(
        Request         $request,
        SitemapService  $service,
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
        $garages  = $service->cacheCreate()['garages'];
        $missions = $service->cacheCreate()['missions'];
        $races    = $service->cacheCreate()['races'];
        // Pages
//        $urls[] = ['loc' => $this->generateUrl('app.page.filter.gold')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.filter.locked')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.filter.to.gold')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.filter.to.unlock')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.filter.to.upgrade')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.filter.unlock')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.order.class')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.order.event')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.order.stat')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.search.garage')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.search.race')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.setting.blueprint')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.setting.level')];
//        $urls[] = ['loc' => $this->generateUrl('app.page.setting.rank')];

        // Garages URL
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
        foreach ($missions as $mission) {
            $urls[] = [
                'loc' => $this->generateUrl('app.mission.update', ['id' => $mission['id']]),
            ];
            $urls[] = [
                'loc' => $this->generateUrl('app.mission.delete', ['id' => $mission['id']]),
            ];
        }
        foreach ($races as $race) {
            $urls[] = [
                'loc' => $this->generateUrl('app.race.update', ['id' => $race['id'], 'slug' => $race['slug']]),
            ];
            $urls[] = [
                'loc' => $this->generateUrl('app.race.delete', ['id' => $race['id']]),
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
