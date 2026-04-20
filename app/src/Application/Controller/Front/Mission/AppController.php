<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Mission;

use App\Application\Service\Controller\WebController;
use App\Domain\Abstract\BaseController;
use App\Domain\Repository\MissionAppRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/mission',
    name: 'app.mission.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class AppController extends BaseController
{
    use WebController;

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'app.mission.index',
      'create' => 'admin.mission.app.create',
      'read'   => null,
      'update' => 'admin.mission.app.update',
      'delete' => 'admin.mission.app.delete',
    ];

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, MissionAppRepository $repository): Response
    {
        ### Variables
        $dashboard  = $this->translator->trans('text.dashboard');
        $title      = $this->translator->trans('text.all.missions');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => null, 'parameters' => []],
        ];

        return $this->render('@App/theme-lte/contents/front/page/mission.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => self::$crud,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->findAll(),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }
}
