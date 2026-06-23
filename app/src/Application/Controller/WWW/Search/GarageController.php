<?php

declare(strict_types=1);

namespace App\Application\Controller\WWW\Search;

use App\Domain\Form\SearchGarageAppType;
use App\Domain\Repository\GarageAppRepository;
use App\Infrastructure\Abstract\Controller\AbstractBaseController;
use App\Infrastructure\DTO\Search\GarageDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/search',
    name: 'app.page.search.',
    options: ['expose' => false],
    methods: ['GET', 'POST'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class GarageController extends AbstractBaseController
{
    /** @description link to pages */
    public static array $crud = [
        'index'  => 'app.search.garage',
        'create' => null,
        'read'   => null,
        'update' => null,
        'delete' => null,
    ];

    #[Route(path: '/garage.php', name: 'garage')]
    public function garage(
        Request $request,
        GarageAppRepository $repository,
        TranslatorInterface $translator,
    ): Response
    {
        ### Variables
        $result     = [];
        $dashboard  = $translator->trans('text.dashboard');
        $search     = $translator->trans('text.search');
        $title      = $translator->trans('text.garage');
        $dto        = new GarageDTO();
        $form       = $this->createForm(SearchGarageAppType::class, $dto)->handleRequest($request);
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'params' => []],
            ['label' => $search, 'route' => 'app.search.garage', 'params' => []],
            ['label' => $title, 'route' => null, 'params' => []],
        ];

        ### Form
        if ($form->isSubmitted() && $form->isValid()) {
            $result = $repository->search($dto);
        }

        ### Datas
        return $this->render('@App/themes/lte/contents/search/garage.html.twig', [
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
