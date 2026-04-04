<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Persistence\Entity\InventoryApp;
use App\Persistence\Form\Front\DashboardInventoryType;
use App\Persistence\Repository\InventoryAppRepository;
use App\Toolbox\File\YAML;
use App\Toolbox\System\Path;
use App\Toolbox\Trait\Controller\WebController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    name: 'app.dashboard.',
    options: ['expose' => false],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class DashboardController extends AbstractController
{
    use WebController;

    #[Route(path: '{_locale<%app.supported_locales%>}/index.php', name: 'index')]
    public function index(
        Request $request,
        InventoryAppRepository $repository,
    ): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.front-office');
        $title = $this->translator->trans('text.dashboard');

        ### Création des formulaires
        $moneys  = $repository->findByCategory('money');
        foreach ($moneys as $money) {
            /** @var InventoryApp $money */
            $moneys[$money->getSlug()] = $this->createForm(DashboardInventoryType::class, $money)->handleRequest($request);
        }

        $jokers  = $repository->findByCategory('joker');
        foreach ($jokers as $money) {
            /** @var InventoryApp $money */
            $jokers[$money->getSlug()] = $this->createForm(DashboardInventoryType::class, $money)->handleRequest($request);
        }

        $rares   = $repository->findByCategory('rare');
        foreach ($rares as $money) {
            /** @var InventoryApp $money */
            $rares[$money->getSlug()] = $this->createForm(DashboardInventoryType::class, $money)->handleRequest($request);
        }

        $commons = $repository->findByCategory('common');
        foreach ($commons as $money) {
            /** @var InventoryApp $money */
            $commons[$money->getSlug()] = $this->createForm(DashboardInventoryType::class, $money)->handleRequest($request);
        }

        ### Flash
//        $this->addFlash('secondary', 'Inventory ' . $this->translator->trans('notification.updated');
//        $this->addFlash('secondary', 'This is the Web App !');

        return $this->render('@App/contents/front/dashboard/index.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container-fluid',
            'breadcrumb'      => self::Breadcrump($home, $title),
            // Forms
            'credits'         => $moneys['credits'],
            'tokens'          => $moneys['tokens'],
            'epics'           => $moneys['epics'],
            'overlocks'       => $moneys['overlocks'],
            'gauntlet'        => $moneys['gauntlet'],
            'style'           => $moneys['style'],
            'vip'             => $moneys['vip'],
            'joker_1_d'       => $jokers['joker-d-1-d'],
            'joker_1_c'       => $jokers['joker-c-1-c'],
            'joker_1_b'       => $jokers['joker-b-1-b'],
            'joker_1_a'       => $jokers['joker-a-1-a'],
            'joker_1_s'       => $jokers['joker-s-1-s'],
            'joker_2_d'       => $jokers['joker-d-2-d'],
            'joker_2_c'       => $jokers['joker-c-2-c'],
            'joker_2_b'       => $jokers['joker-b-2-b'],
            'joker_2_a'       => $jokers['joker-a-2-a'],
            'joker_2_s'       => $jokers['joker-s-2-s'],
            'joker_3_d'       => $jokers['joker-d-3-d'],
            'joker_3_c'       => $jokers['joker-c-3-c'],
            'joker_3_b'       => $jokers['joker-b-3-b'],
            'joker_3_a'       => $jokers['joker-a-3-a'],
            'joker_3_s'       => $jokers['joker-s-3-s'],
            'joker_4_d'       => $jokers['joker-d-4-d'],
            'joker_4_c'       => $jokers['joker-c-4-c'],
            'joker_4_b'       => $jokers['joker-b-4-b'],
            'joker_4_a'       => $jokers['joker-a-4-a'],
            'joker_4_s'       => $jokers['joker-s-4-s'],
            'joker_5_d'       => $jokers['joker-d-5-d'],
            'joker_5_c'       => $jokers['joker-c-5-c'],
            'joker_5_b'       => $jokers['joker-b-5-b'],
            'joker_5_a'       => $jokers['joker-a-5-a'],
            'joker_5_s'       => $jokers['joker-s-5-s'],
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
            'speed'           => $commons['speed'],
            'acceleration'    => $commons['acceleration'],
            'handling'        => $commons['handling'],
            'nitro'           => $commons['nitro'],
            // Stats
            'stat_garage'             => $this->GarageByClass(),
            'stat_block'              => $this->FilterByClass('filter-block-*.yaml'),
            'stat_gold'               => $this->FilterByClass('filter-gold-*.yaml'),
            'stat_to_upgrade'         => $this->FilterByClass('filter-to-upgrade-*.yaml'),
            'stat_unblock'            => $this->FilterByClass('filter-unblock-*.yaml'),
            'stat_full_blueprint'     => $this->FilterByClass('full-blueprint-*.yaml'),
            'stat_to_gold'            => $this->FilterByClass('to-gold-*.yaml'),
//            'stat_to_install_import'  => $this->FilterByClass('to-install-import-*.yaml'),
//            'stat_to_install_upgrade' => $this->FilterByClass('to-install-upgrade-*.yaml'),
//            'stat_to_unblock'         => $this->FilterByClass('to-unblock-*.yaml'),
        ]);
    }

    #[Route(path: '/', name: 'noLocale')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app.dashboard.index', ['_locale' => 'en'], Response::HTTP_PERMANENTLY_REDIRECT);
    }

    #[Route(path: '{_locale<%app.supported_locales%>}/test.php', name: 'test')]
    public function test(Request $request): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.front-office');
        $title = $this->translator->trans('text.dashboard');

        return $this->render('@App/contents/front/dashboard/test.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => self::Breadcrump($home, $title),
        ]);
    }

    /** PRIVATE METHODS */

    private function GarageByClass(): array
    {
        ### init count
        $class_D = $class_C = $class_B = $class_A = $class_S = 0;

        ### search file
        $directory = Path::canonicalize($this->parameter->get('folders.yaml.index')) . DIRECTORY_SEPARATOR;
        $datas     = YAML::FileToArray($directory . 'app-garage.yaml');

        ### result
        if (is_array($datas)) {
            foreach ($datas as $item) {
                $value = $item['class_value'];
                match ($value) {
                    'S' => $class_S++,
                    'A' => $class_A++,
                    'B' => $class_B++,
                    'C' => $class_C++,
                    'D' => $class_D++,
                };
            }

            return [
                'D' => $class_D,
                'C' => $class_C,
                'B' => $class_B,
                'A' => $class_A,
                'S' => $class_S,
                'T' => count($datas),
            ];
        }

        return [];
    }

    private function FilterByClass(string $filter): array
    {
        ### init count
        $class_D = $class_C = $class_B = $class_A = $class_S = $total = 0;

        ### search file
        $directory = Path::canonicalize($this->parameter->get('folders.yaml.page')) . DIRECTORY_SEPARATOR;
        $files     = glob($directory . $filter);

        foreach ($files as $file) {
            $datas = YAML::FileToArray($file);

            ### result
            if (is_array($datas)) {
                foreach ($datas as $item) {
                    if (isset($item['garage']['settingClass'])) {
                        $value = $item['garage']['settingClass']['value'];
                        match ($value) {
                            'S' => $class_S++,
                            'A' => $class_A++,
                            'B' => $class_B++,
                            'C' => $class_C++,
                            'D' => $class_D++,
                        };
                    }
                }
            }

            $total += count($datas);
        }

        return [
            'D' => $class_D,
            'C' => $class_C,
            'B' => $class_B,
            'A' => $class_A,
            'S' => $class_S,
            'T' => $total,
        ];
    }
}
