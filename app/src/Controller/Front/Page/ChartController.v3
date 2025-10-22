<?php

namespace App\Controller\Web\Page;

use App\Repository\GarageBooleanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/chart.php', name: 'app.page.chart.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
final class ChartController extends AbstractController
{
    public function __construct(
        private readonly GarageBooleanRepository $booleans,
        private readonly TranslatorInterface $translator,
//        private readonly ChartBuilderInterface $chartBuilder,
    ) {}

    #[Route('', name: 'index')]
    public function index(): Response
    {
        $title = $this->translator->trans('controllerName.app.page.order.class');

        $this->getTotal();

        return $this->render('@App/app/page/chart/index.html.twig', [
            'controller_name' => $title,
        ]);
    }

    /**
     * @return array<string, int>
     */
    private function getTotal(): array
    {
        /** Conditions */
        $total     = [];
        $unlock    = ['locked' => false];
        $locked    = ['where' => 'locked', 'value' => true];
        $gold      = ['locked' => false, 'gold'      => true];
        $tounlock  = ['locked' => false, 'toUnlock'  => true];
        $toupgrade = ['locked' => false, 'toUpgrade' => true];
        $togold    = ['locked' => true, 'toGold'     => true];

        /** Query */
//        $booleans = $this->booleans->findBy($locked, [], 10);
        $booleans = $this->booleans->getCarsByClass('B', $locked);
        dd($booleans);
    }


}
