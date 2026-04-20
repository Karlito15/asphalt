<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Page;

use App\Application\Service\Controller\WebController;
use App\Domain\Abstract\BaseController;
use App\Domain\Repository\GarageAppRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/pages/order',
    name: 'app.page.order.',
    requirements: ['letter' => Requirement::ASCII_SLUG],
    options: ['expose' => false],
    defaults: ['letter' => 'S'],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class OrderController extends BaseController
{
    use WebController;

    #[Route(path: '/class/class-{letter}.php', name: 'class')]
    public function class(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.order') . ' by ' . $this->translator->trans('text.class');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.order.class', null, 'parameters' => []],
        ];

        // Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageOrder(['settingClass.value' => $letter], ['g.carOrder' => 'ASC']),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/stat/class-{letter}.php', name: 'stat')]
    public function stat(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.order') . ' by ' . $this->translator->trans('text.stat');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.order.stat', null, 'parameters' => []],
        ];

        // Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageOrder(['settingClass.value' => $letter], ['g.statOrder' => 'ASC']),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }
}
