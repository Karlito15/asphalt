<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Search;

use App\Application\DTO\Search\GarageDTO;
use App\Application\Service\Controller\WebController;
use App\Domain\Abstract\BaseController;
use App\Domain\Form\Front\Search\GarageAppType;
use App\Domain\Repository\GarageAppRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/search',
    name: 'app.search.',
    options: ['expose' => false],
    methods: ['GET', 'POST'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class GarageController extends BaseController
{
    use WebController;

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'app.search.garage',
      'create' => null,
      'read'   => null,
      'update' => null,
      'delete' => null,
    ];

    #[Route(path: '/garage.php', name: 'garage')]
    public function garage(Request $request, GarageAppRepository $repository): Response
    {
        ### Variables
        $result     = [];
        $dashboard  = $this->translator->trans('text.dashboard');
        $search     = $this->translator->trans('text.search');
        $title      = $this->translator->trans('text.garage');
        $dto        = new GarageDTO();
        $form       = $this->createForm(GarageAppType::class, $dto)->handleRequest($request);
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $search, 'route' => 'app.search.garage', 'parameters' => []],
            ['label' => $title, 'route' => null, 'parameters' => []],
        ];

        ### Form
        if ($form->isSubmitted() && $form->isValid()) {
            $result = $repository->search($dto);
        }

        ### Datas
        return $this->render('@App/theme-lte/contents/front/search/garage.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'links'             => self::$crud,
            'controller_name'   => $search . ' ' . $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $result,
            'form'              => $form->createView(),
            'count'             => count($result),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
        ]);
    }
}
