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
    path: '/{_locale<%app.supported_locales%>}/pages/filter',
    name: 'app.page.filter.',
    requirements: ['letter' => Requirement::ASCII_SLUG],
    options: ['expose' => false],
    defaults: ['letter' => 'S'],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class FilterController extends BaseController
{
    use WebController;

    #[Route(path: '/block/class-{letter}.php', name: 'block')]
    public function block(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.filter') . ' by ' . $this->translator->trans('text.block');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.filter.block', null, 'parameters' => []],
        ];
        $query      = [
            'status.unblock' => false,
            'settingClass.value' => $letter,
        ];

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageFilter($query),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/gold/class-{letter}.php', name: 'gold')]
    public function gold(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.filter') . ' by ' . $this->translator->trans('text.gold');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.filter.gold', null, 'parameters' => []],
        ];
        $query      = [
            'status.unblock' => true,
            'status.gold' => true,
            'settingClass.value' => $letter,
        ];

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageFilter($query),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/unblock/class-{letter}.php', name: 'unblock')]
    public function unblock(Request $request, GarageAppRepository $repository): Response
    {
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.filter') . ' by ' . $this->translator->trans('text.unblock');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.filter.unblock', null, 'parameters' => []],
        ];
        $query      = [
            'status.unblock' => true,
            'settingClass.value' => $letter,
        ];

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageFilter($query),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/evo/class-{letter}.php', name: 'evo')]
    public function evo(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.filter') . ' by ' . $this->translator->trans('text.evo');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.filter.evo', null, 'parameters' => []],
        ];
        $query      = [
            'status.evo'            => true,
            'settingClass.value'    => $letter,
        ];

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageFilter($query),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/event-class-{letter}.php', name: 'event')]
    public function event(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.filter') . ' by ' . $this->translator->trans('text.event.class');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.filter.event', null, 'parameters' => []],
        ];
        $query      = [
            'status.eventClass'     => true,
            'settingClass.value'    => $letter,
        ];

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageFilter($query),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/to-upgrade/class-{letter}.php', name: 'to.upgrade')]
    public function toUpgrade(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.filter') . ' by ' . $this->translator->trans('text.to.upgrade');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.filter.to.upgrade', null, 'parameters' => []],
        ];
        $query      = [
            'status.toUpgrade'      => true,
            'settingClass.value'    => $letter,
        ];

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageFilter($query),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/to-install-upgrade/class-{letter}.php', name: 'to.install.upgrade')]
    public function toInstallUpgrade(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.filter') . ' by ' . $this->translator->trans('text.to.install.upgrade');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.filter.to.install.upgrade', null, 'parameters' => []],
        ];

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageFilter([]),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/to-install-import/class-{letter}.php', name: 'to.install.import')]
    public function toInstallImport(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.filter') . ' by ' . $this->translator->trans('text.to.install.import');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.filter.to.install.import', null, 'parameters' => []],
        ];

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageFilter([]),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/to-gold/class-{letter}.php', name: 'to.gold')]
    public function toGold(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.filter') . ' by ' . $this->translator->trans('text.to.gold');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.filter.to.gold', null, 'parameters' => []],
        ];

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageFilter([]),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/full-blueprint/class-{letter}.php', name: 'full.blueprint')]
    public function fullBlueprint(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.filter') . ' by ' . $this->translator->trans('text.full.blueprint');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.filter.full.blueprint', null, 'parameters' => []],
        ];

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageFilter([]),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }

    #[Route(path: '/full-evo/class-{letter}.php', name: 'full.evo')]
    public function fullEvo(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $letter     = self::Letter($request->attributes->get('letter'));
        $match      = self::ControlLetter($letter);
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.filter') . ' by ' . $this->translator->trans('text.full.evo');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => 'app.page.filter.full.evo', null, 'parameters' => []],
        ];

        ### Letter Not Match
        $this->return404($match);

        return $this->render('@App/theme-lte/contents/front/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => [],
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->getGaragePageFilter([]),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }
}
