<?php

namespace App\Controller\Front;

use App\Entity\InventoryApp;
use App\Form\Front\InventoryAppType;
use App\Service\Cache\DashboardService;
use App\Service\Cache\StatisticService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'app.dashboard.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class DashboardController extends AbstractController
{
    /**
     * @param DashboardService $dashboardService
     * @param StatisticService $statisticService
     * @param Request $request
     * @param TranslatorInterface $translator
     * @return Response
     */
    #[Route(path: '{_locale<%app.supported_locales%>}/index.php', name: 'index')]
    public function index(
        DashboardService $dashboardService,
        StatisticService $statisticService,
        Request $request,
        TranslatorInterface $translator,
    ): Response
    {
        // Variables
        $title      = $translator->trans('text.dashboard');
        $dashboard  = $dashboardService->cacheCreate();
        $statistic  = $statisticService->cacheCreate();
        $moneys     = [];
        $commons    = [];
        $rares      = [];
        $jokers     = [];

        // Création du formulaire
        foreach ($dashboard['moneys'] as $money) {
            /** @var InventoryApp $money */
            $moneys[$money->getSlug()] = $this->createForm(InventoryAppType::class, $money)->handleRequest($request);
        }

        foreach ($dashboard['commons'] as $money) {
            /** @var InventoryApp $money */
            $commons[$money->getSlug()] = $this->createForm(InventoryAppType::class, $money)->handleRequest($request);
        }

        foreach ($dashboard['rares'] as $money) {
            /** @var InventoryApp $money */
            $rares[$money->getSlug()] = $this->createForm(InventoryAppType::class, $money)->handleRequest($request);
        }

        foreach ($dashboard['jokers'] as $money) {
            /** @var InventoryApp $money */
            $jokers[$money->getSlug()] = $this->createForm(InventoryAppType::class, $money)->handleRequest($request);
        }

        // Flash
        // $this->addFlash('success', ['title' => 'Inventory', 'message' => 'Inventory ' . $translator->trans('notification.updated')]);

        return $this->render('@App/front/contents/dashboard/index.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container-fluid',
            'breadcrumb'      => ['level1' => $translator->trans('text.front-office'), 'level2' => $title],
            'links'           => [],
            'credits'         => $moneys['credits'],
            'tokens'          => $moneys['tokens'],
            'epics'           => $moneys['epics'],
            'overlocks'       => $moneys['overlocks'],
            'gauntlet'        => $moneys['gauntlet'],
            'style'           => $moneys['style'],
            'vip'             => $moneys['vip'],
            'speed'           => $commons['speed'],
            'acceleration'    => $commons['acceleration'],
            'handling'        => $commons['handling'],
            'nitro'           => $commons['nitro'],
            'speed_d'         => $rares['speed-d'],
            'speed_c'         => $rares['speed-c'],
            'speed_b'         => $rares['speed-b'],
            'speed_a'         => $rares['speed-a'],
            'speed_s'         => $rares['speed-s'],
            'acceleration_d'  => $rares['acceleration-d'],
            'acceleration_c'  => $rares['acceleration-c'],
            'acceleration_b'  => $rares['acceleration-b'],
            'acceleration_a'  => $rares['acceleration-a'],
            'acceleration_s'  => $rares['acceleration-s'],
            'handling_d'      => $rares['handling-d'],
            'handling_c'      => $rares['handling-c'],
            'handling_b'      => $rares['handling-b'],
            'handling_a'      => $rares['handling-a'],
            'handling_s'      => $rares['handling-s'],
            'nitro_d'         => $rares['nitro-d'],
            'nitro_c'         => $rares['nitro-c'],
            'nitro_b'         => $rares['nitro-b'],
            'nitro_a'         => $rares['nitro-a'],
            'nitro_s'         => $rares['nitro-s'],
            'joker_1_d'       => $jokers['joker-1-d'],
            'joker_1_c'       => $jokers['joker-1-c'],
            'joker_1_b'       => $jokers['joker-1-b'],
            'joker_1_a'       => $jokers['joker-1-a'],
            'joker_1_s'       => $jokers['joker-1-s'],
            'joker_2_d'       => $jokers['joker-2-d'],
            'joker_2_c'       => $jokers['joker-2-c'],
            'joker_2_b'       => $jokers['joker-2-b'],
            'joker_2_a'       => $jokers['joker-2-a'],
            'joker_2_s'       => $jokers['joker-2-s'],
            'joker_3_d'       => $jokers['joker-3-d'],
            'joker_3_c'       => $jokers['joker-3-c'],
            'joker_3_b'       => $jokers['joker-3-b'],
            'joker_3_a'       => $jokers['joker-3-a'],
            'joker_3_s'       => $jokers['joker-3-s'],
            'joker_4_d'       => $jokers['joker-4-d'],
            'joker_4_c'       => $jokers['joker-4-c'],
            'joker_4_b'       => $jokers['joker-4-b'],
            'joker_4_a'       => $jokers['joker-4-a'],
            'joker_4_s'       => $jokers['joker-4-s'],
            'joker_5_d'       => $jokers['joker-5-d'],
            'joker_5_c'       => $jokers['joker-5-c'],
            'joker_5_b'       => $jokers['joker-5-b'],
            'joker_5_a'       => $jokers['joker-5-a'],
            'joker_5_s'       => $jokers['joker-5-s'],
            'statistic'       => $statistic,
        ]);
    }

    #[Route(path: '/', name: 'noLocale')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app.dashboard.index', ['_locale' => 'en'], Response::HTTP_PERMANENTLY_REDIRECT);
    }
}
