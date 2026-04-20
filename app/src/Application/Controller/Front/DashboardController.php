<?php

declare(strict_types=1);

namespace App\Application\Controller\Front;

use App\Application\Service\Controller\WebController;
use App\Domain\Abstract\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/',
    name: 'app.dashboard.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class DashboardController extends BaseController
{
    use WebController;

    #[Route(path: '{_locale<%app.supported_locales%>}/index.php', name: 'index')]
    public function index(Request $request): Response
    {
        ### Variables
        $dashboard  = $this->translator->trans('text.home');
        $title      = $this->translator->trans('text.dashboard');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => null, 'parameters' => []],
        ];

        ### Flash
        // $this->addFlash('primary', 'This is the Web App !');

        return $this->render('@App/theme-lte/contents/front/dashboard/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/', name: 'noLocale')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app.dashboard.index', ['_locale' => 'en'], Response::HTTP_PERMANENTLY_REDIRECT);
    }
}
