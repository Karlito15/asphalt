<?php

declare(strict_types=1);

namespace App\Application\Controller\WWW\Garage;

use App\Domain\Repository\GarageAppRepository;
use App\Infrastructure\Abstract\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/garage',
    name: 'app.garage.',
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
        'index'  => 'app.garage.index',
        'create' => 'app.garage.create',
        'read'   => 'app.garage.read',
        'update' => 'app.garage.update',
        'delete' => 'app.garage.delete',
    ];

    #[Route(path: '/index.php', name: 'index')]
    public function index(
        GarageAppRepository $repository,
        Request $request,
        TranslatorInterface $translator
    ): Response
    {
        ### Variables
        $dashboard  = $translator->trans('text.dashboard');
        $title      = $translator->trans('text.all.cars');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'params' => []],
            ['label' => $title,     'route' => 'app.dashboard.index', 'params' => []],
        ];

        return $this->render('@App/themes/lte/contents/garage/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => self::$crud,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->findList(),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }
}
