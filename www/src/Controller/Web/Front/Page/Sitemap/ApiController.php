<?php

namespace App\Controller\Web\Front\Page\Sitemap;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sitemap', name: 'sitemap.', schemes: ['http', 'https'], format: 'xml', utf8: true)]
final class ApiController extends AbstractController
{
    #[Route('/api.xml', name: 'api', methods: ['GET'])]
    public function admin(
        Request $request,
    ): Response
    {
        // Host
        $hostname = $request->getSchemeAndHttpHost();

        // Results
        $urls   = [];

        // Urls Statiques
        $urls[] = ['loc' => $this->generateUrl('api.dashboard.index')];
        $urls[] = ['loc' => $this->generateUrl('api.garage.index')];
        $urls[] = ['loc' => $this->generateUrl('api.inventory.index')];
        $urls[] = ['loc' => $this->generateUrl('api.mission.index')];
        $urls[] = ['loc' => $this->generateUrl('api.mission.task.index')];
        $urls[] = ['loc' => $this->generateUrl('api.mission.type.index')];
        $urls[] = ['loc' => $this->generateUrl('api.race.index')];
        $urls[] = ['loc' => $this->generateUrl('api.race.mode.index')];
        $urls[] = ['loc' => $this->generateUrl('api.race.region.index')];
        $urls[] = ['loc' => $this->generateUrl('api.race.season.index')];
        $urls[] = ['loc' => $this->generateUrl('api.race.time.index')];
        $urls[] = ['loc' => $this->generateUrl('api.race.track.index')];
        $urls[] = ['loc' => $this->generateUrl('api.setting.blueprint.index')];
        $urls[] = ['loc' => $this->generateUrl('api.setting.brand.index')];
        $urls[] = ['loc' => $this->generateUrl('api.setting.class.index')];
        $urls[] = ['loc' => $this->generateUrl('api.setting.level.index')];
        $urls[] = ['loc' => $this->generateUrl('api.setting.tag.index')];
        $urls[] = ['loc' => $this->generateUrl('api.setting.unit-price.index')];

        // Urls Dynamiques

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
