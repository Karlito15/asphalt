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
final class BackController extends AbstractController
{
    #[Route('/back.xml', name: 'back')]
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
        $urls[]   = ['loc' => $this->generateUrl('admin.dashboard.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.inventory.app.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.inventory.app.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.mission.task.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.mission.task.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.mission.type.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.mission.type.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.race.mode.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.race.mode.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.race.region.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.race.region.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.race.season.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.race.season.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.race.time.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.race.time.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.race.track.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.race.track.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.setting.blueprint.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.setting.blueprint.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.setting.brand.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.setting.brand.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.setting.class.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.setting.class.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.setting.level.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.setting.level.create')];
        $urls[]   = ['loc' => $this->generateUrl('admin.setting.unit-price.index')];
        $urls[]   = ['loc' => $this->generateUrl('admin.setting.unit-price.create')];

        ### Urls Dynamiques
        dump($service);

        ### Response
        return new Response(
            $this->renderView('@App/contents/sitemap/index.xml.twig', [
                'controller_name' => 'Back',
                'urls'            => $urls,
                'hostname'        => $hostname,
            ]), Response::HTTP_OK
        );
    }
}
