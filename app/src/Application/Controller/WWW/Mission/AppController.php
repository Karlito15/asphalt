<?php

declare(strict_types=1);

namespace App\Application\Controller\WWW\Mission;

use App\Domain\Repository\MissionAppRepository;
use App\Infrastructure\Abstract\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/mission',
    name: 'app.mission.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class AppController extends AbstractBaseController
{
    /** @description link to pages */
    public static array $crud = [
        'index'  => 'app.mission.index',
        'create' => null,
        'read'   => null,
        'update' => null,
        'delete' => null,
    ];

    #[Route(path: '/index.php', name: 'index')]
    public function index(
        Request $request,
        MissionAppRepository $repository,
        TranslatorInterface $translator,
    ): Response
    {
        ### Variables
        $dashboard  = $translator->trans('text.dashboard');
        $title      = $translator->trans('text.all.missions');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'params' => []],
            ['label' => $title, 'route' => null, 'params' => []],
        ];

        return $this->render('@App/themes/lte/contents/page/mission.html.twig', [
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
