<?php

namespace App\Controller\Web\Front\Page\Sitemap;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sitemap', name: 'sitemap.', methods: ['GET'], format: 'xml', utf8: true)]
final class FrontController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    )
    {}

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
//    #[Route('/front', name: 'app_front')]
//    public function index(): JsonResponse
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/FrontController.php',
//        ]);
//    }
}
