<?php

declare(strict_types=1);

namespace App\Application\Controller\WWW;

use App\Domain\Repository\InventoryAppRepository;
use App\Domain\Form\InventoryAppType;
use App\Domain\Repository\StatisticalGarageRepository;
use App\Infrastructure\Abstract\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/',
    name: 'app.dashboard.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class DashboardController extends AbstractBaseController
{
    /** @description link to pages */
    public static array $crud = [
      'index'  => 'app.dashboard.index',
      'create' => null,
      'read'   => null,
      'update' => null,
      'delete' => null,
    ];

    #[Route(path: '{_locale<%app.supported_locales%>}/index.php', name: 'index')]
    public function index(
        Request $request,
        TranslatorInterface $translator,
        InventoryAppRepository $repository,
        StatisticalGarageRepository $statistical,
    ): Response
    {
        ### Variables
        $dashboard  = $translator->trans('text.home');
        $title      = $translator->trans('text.dashboard');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'params' => []],
            ['label' => $title, 'route' => null, 'params' => []],
        ];

        ### Création des formulaires
        $moneys  = $repository->findByCategory('money');
        foreach ($moneys as $item) {
            $formMoneys[$item->getId()] = $this->createForm(InventoryAppType::class, $item)->handleRequest($request);
        }

        $jokers  = $repository->findByCategory('joker');
        foreach ($jokers as $item) {
            $formJokers[$item->getId()] = $this->createForm(InventoryAppType::class, $item)->handleRequest($request);
        }

        $rares   = $repository->findByCategory('rare');
        foreach ($rares as $item) {
            $formRares[$item->getId()] = $this->createForm(InventoryAppType::class, $item)->handleRequest($request);
        }

        $commons = $repository->findByCategory('common');
        foreach ($commons as $item) {
            $formCommons[$item->getId()] = $this->createForm(InventoryAppType::class, $item)->handleRequest($request);
        }

        ### Flash
        $this->addFlash(type: 'info', message: 'This is the Web App !');

        return $this->render('@App/themes/lte/contents/dashboard/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
            ### Forms
            'moneys'            => $formMoneys,
            'jokers'            => $formJokers,
            'rares'             => $formRares,
            'commons'           => $formCommons,
            ### Stats
            'alls'              => $statistical->findOneBy(['slug' => 'garage-alls']),
            'blocks'            => $statistical->findOneBy(['slug' => 'garage-blocks']),
            'unblocks'          => $statistical->findOneBy(['slug' => 'garage-unblocks']),
            'golds'             => $statistical->findOneBy(['slug' => 'garage-golds']),
            'toUpgrades'        => $statistical->findOneBy(['slug' => 'garage-to-upgrades']),
        ]);
    }

    #[Route(path: '/', name: 'noLocale')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute(
            route: 'app.dashboard.index',
            parameters: ['_locale' => 'en'],
            status: Response::HTTP_PERMANENTLY_REDIRECT
        );
    }
}
