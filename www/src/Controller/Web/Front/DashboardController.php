<?php

namespace App\Controller\Web\Front;

use App\Service\Cache\DashboardService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'app.dashboard.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class DashboardController extends AbstractController
{
    private static string $page = 'Dashboard';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    /**
     * @param Request $request
     * @param DashboardService $cacheDashboardService
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route(path: '{_locale<%app.supported_locales%>}/index.php', name: 'index')]
    public function index(Request $request, DashboardService $cacheDashboardService): Response
    {
        $title          = $this->translator->trans('app.dashboard.index.title');
        $dashboard      = $cacheDashboardService->cacheCreate();

        return $this->render('@App/contents/front/dashboard/index.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => $title,
            'dashboard'         => $dashboard,
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
