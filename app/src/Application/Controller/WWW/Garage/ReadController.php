<?php

declare(strict_types=1);

namespace App\Application\Controller\WWW\Garage;

use App\Domain\Entity\GarageApp;
use App\Infrastructure\Abstract\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/garage',
    name: 'app.garage.',
    requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG],
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class ReadController extends AbstractBaseController
{
    /** @description link to pages */
    public static array $crud = [
        'index'  => 'app.garage.index',
        'create' => 'app.garage.create',
        'read'   => 'app.garage.read',
        'update' => 'app.garage.update',
        'delete' => 'app.garage.delete',
    ];

    #[Route('/read/{id}/{slug}.php', name: 'read')]
    public function read(
        GarageApp $entity,
        Request $request,
        TranslatorInterface $translator,
    ): Response
    {
        ### Variables
        $dashboard  = $translator->trans('text.dashboard');
        $garage     = $translator->trans('text.garage');
        $current    = $translator->trans('text.read');
		$title      = $entity->getSettingBrand()->getName() . ' ' . $entity->getModel();
        $params     = ['id' => $entity->getId(), 'slug' => $entity->getSlug()];
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'params' => []],
            ['label' => $garage,    'route' => 'app.garage.index',    'params' => []],
            ['label' => $current,   'route' => 'app.garage.read',     'params' => $params],
        ];

        return $this->render('@App/themes/lte/contents/garage/read.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => self::$crud,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entity'            => $entity,
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }
}
