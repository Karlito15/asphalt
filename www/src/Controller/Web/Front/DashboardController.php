<?php

namespace App\Controller\Web\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'app.dashboard.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class DashboardController extends AbstractController
{
    private static string $page = 'Dashboard';

    public function __construct(
        private readonly TranslatorInterface $translator,
//        private readonly InventoryService $inventoryService,
//        private readonly StatisticalService $statisticalService,
    ) {}

    /**
     * @param Request $request
     * @return Response
     */
    #[Route(path: '{_locale<%app.supported_locales%>}/index.php', name: 'index')]
    public function index(Request $request): Response
    {
        $title          = $this->translator->trans('app.dashboard.index.title');
//        $database       = $this->inventoryService->createDataCache('inventories');
//        $statistic      = $this->statisticalService->createDataCache('statistical');

        return $this->render('@App/contents/front/dashboard/index.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => $title,
//            'formCredit'        => $this->createForm(InventoryType::class, $database['credits'])->handleRequest($request),
//            'moneys'            => $database['moneys'],
//            'jokers'            => $database['jokers'],
//            'rares'             => $database['rares'],
//            'commons'           => $database['commons'],
            // ToDo >>> Add Statistical
//            'statistic'         => $statistic,
        ]);
    }

    #[Route(path: '/', name: 'noLocale')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app.dashboard.index', [
            '_locale' => 'en'
        ], Response::HTTP_PERMANENTLY_REDIRECT);
    }
}
