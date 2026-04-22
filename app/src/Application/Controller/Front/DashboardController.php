<?php

declare(strict_types=1);

namespace App\Application\Controller\Front;

use App\Application\Service\Controller\WebController;
use App\Domain\Abstract\BaseController;
use App\Domain\Form\Front\Inventory\AppType;
use App\Domain\Repository\InventoryAppRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/',
    name: 'app.dashboard.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class DashboardController extends BaseController
{
    use WebController;


    #[Route(path: '{_locale<%app.supported_locales%>}/index.php', name: 'index')]
    public function index(Request $request, InventoryAppRepository $repository): Response
    {
        ### Variables
        $dashboard  = $this->translator->trans('text.home');
        $title      = $this->translator->trans('text.dashboard');
        $breadcrumb = [
            ['label' => $dashboard, 'route' => 'app.dashboard.index', 'parameters' => []],
            ['label' => $title, 'route' => null, 'parameters' => []],
        ];

        ### Création des formulaires
        $moneys  = $repository->findByCategory('money');
        foreach ($moneys as $money) {
            $moneys[$money->getSlug()] = $this->createForm(AppType::class, $money)->handleRequest($request);
        }

        $jokers  = $repository->findByCategory('joker');
        foreach ($jokers as $money) {
            $jokers[$money->getSlug()] = $this->createForm(AppType::class, $money)->handleRequest($request);
        }

        $rares   = $repository->findByCategory('rare');
        foreach ($rares as $money) {
            $rares[$money->getSlug()] = $this->createForm(AppType::class, $money)->handleRequest($request);
        }

        $commons = $repository->findByCategory('common');
        foreach ($commons as $money) {
            $commons[$money->getSlug()] = $this->createForm(AppType::class, $money)->handleRequest($request);
        }

        ### Flash
        // $this->addFlash('primary', 'This is the Web App !');

        return $this->render('@App/theme-lte/contents/front/dashboard/index.html.twig', [
            'breadcrumb'        => self::breadcrumb($breadcrumb),
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'         => 'container-fluid pt-4 px-4',
            'theme'             => 'dark',
            ### Forms
            'credits'           => $moneys['credits'],
            'tokens'            => $moneys['tokens'],
            'epics'             => $moneys['epics'],
            'overlocks'         => $moneys['overlocks'],
            'gauntlet'          => $moneys['gauntlet'],
            'style'             => $moneys['style'],
            'vip'               => $moneys['vip'],
            'joker_1_d'         => $jokers['joker-d-1-d'],
            'joker_1_c'         => $jokers['joker-c-1-c'],
            'joker_1_b'         => $jokers['joker-b-1-b'],
            'joker_1_a'         => $jokers['joker-a-1-a'],
            'joker_1_s'         => $jokers['joker-s-1-s'],
            'joker_2_d'         => $jokers['joker-d-2-d'],
            'joker_2_c'         => $jokers['joker-c-2-c'],
            'joker_2_b'         => $jokers['joker-b-2-b'],
            'joker_2_a'         => $jokers['joker-a-2-a'],
            'joker_2_s'         => $jokers['joker-s-2-s'],
            'joker_3_d'         => $jokers['joker-d-3-d'],
            'joker_3_c'         => $jokers['joker-c-3-c'],
            'joker_3_b'         => $jokers['joker-b-3-b'],
            'joker_3_a'         => $jokers['joker-a-3-a'],
            'joker_3_s'         => $jokers['joker-s-3-s'],
            'joker_4_d'         => $jokers['joker-d-4-d'],
            'joker_4_c'         => $jokers['joker-c-4-c'],
            'joker_4_b'         => $jokers['joker-b-4-b'],
            'joker_4_a'         => $jokers['joker-a-4-a'],
            'joker_4_s'         => $jokers['joker-s-4-s'],
            'joker_5_d'         => $jokers['joker-d-5-d'],
            'joker_5_c'         => $jokers['joker-c-5-c'],
            'joker_5_b'         => $jokers['joker-b-5-b'],
            'joker_5_a'         => $jokers['joker-a-5-a'],
            'joker_5_s'         => $jokers['joker-s-5-s'],
            'speed_d'           => $rares['speed-d'],
            'speed_c'           => $rares['speed-c'],
            'speed_b'           => $rares['speed-b'],
            'speed_a'           => $rares['speed-a'],
            'speed_s'           => $rares['speed-s'],
            'acceleration_d'    => $rares['acceleration-d'],
            'acceleration_c'    => $rares['acceleration-c'],
            'acceleration_b'    => $rares['acceleration-b'],
            'acceleration_a'    => $rares['acceleration-a'],
            'acceleration_s'    => $rares['acceleration-s'],
            'handling_d'        => $rares['handling-d'],
            'handling_c'        => $rares['handling-c'],
            'handling_b'        => $rares['handling-b'],
            'handling_a'        => $rares['handling-a'],
            'handling_s'        => $rares['handling-s'],
            'nitro_d'           => $rares['nitro-d'],
            'nitro_c'           => $rares['nitro-c'],
            'nitro_b'           => $rares['nitro-b'],
            'nitro_a'           => $rares['nitro-a'],
            'nitro_s'           => $rares['nitro-s'],
            'speed'             => $commons['speed'],
            'acceleration'      => $commons['acceleration'],
            'handling'          => $commons['handling'],
            'nitro'             => $commons['nitro'],
        ]);
    }

    #[Route(path: '/', name: 'noLocale')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app.dashboard.index', ['_locale' => 'en'], Response::HTTP_PERMANENTLY_REDIRECT);
    }
}
