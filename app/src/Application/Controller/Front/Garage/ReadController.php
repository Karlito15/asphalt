<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Garage;

use App\Application\Service\Controller\WebController;
use App\Domain\Abstract\BaseController;
use App\Domain\Entity\GarageApp;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

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
final class ReadController extends BaseController
{
    use WebController;

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'app.garage.index',
      'create' => 'app.garage.create',
      'read'   => 'app.garage.read',
      'update' => 'app.garage.update',
      'delete' => 'app.garage.delete',
    ];

    #[Route('/read/{slug}-{id}.php', name: 'read')]
    public function read(Request $request, GarageApp $entity): Response
    {
        ### Variables
        $dashboard  = $this->translator->trans('text.dashboard');
        $garage     = $this->translator->trans('text.garage');
		$title      = $entity->getSettingBrand()->getName() . ' ' . $entity->getModel();
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $garage, 'route' => 'app.garage.index', 'parameters' => []],
            ['label' => $this->translator->trans('text.read'), 'route' => null, 'parameters' => []],
        ];

        return $this->render('@App/theme-lte/contents/front/garage/read.html.twig', [
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
