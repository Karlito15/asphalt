<?php

namespace App\Controller\Web\Front;

use App\Service\Cache\DashboardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'app.dashboard.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class DashboardController extends AbstractController
{
    /**
     * @param DashboardService $cacheService
     * @param Request $request
     * @param TranslatorInterface $translator
     * @return Response
     */
    #[Route(path: '{_locale<%app.supported_locales%>}/index.php', name: 'index')]
    public function index(
        DashboardService $cacheService,
        Request $request,
        TranslatorInterface $translator,
    ): Response
    {
        $title     = $translator->trans('app.dashboard.index.title');
        $dashboard = $cacheService->cacheCreate();

        return $this->render('@App/contents/front/dashboard/index.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => $title, 'level2' => null],
            'links'             => null,
            'dashboard'         => $dashboard,
            'moneys'            => $dashboard['moneys'],
            'commons'           => $dashboard['commons'],
            'rares'             => $dashboard['rares'],
            'jokers'            => $dashboard['jokers'],
        ]);
    }

    #[Route(path: '/', name: 'noLocale')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app.dashboard.index', [
            '_locale' => 'en'
        ], Response::HTTP_PERMANENTLY_REDIRECT);
    }
}
