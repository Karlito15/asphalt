<?php

namespace App\Controller\Web\Front\Page\Setting;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('{_locale<%app.supported_locales%>}/pages/setting/', name: 'app.page.setting.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
final class RankController extends AbstractController
{
    public function __construct(
        private readonly AppGarageRepository $garage,
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('rank-{letter}.php', name: 'rank', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function rank(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.setting.rank');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/setting/rank.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.setting.rank',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->garage->getGarageRank($letter),
        ]);
    }
//    #[Route('/rank', name: 'app_rank')]
//    public function index(): JsonResponse
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/RankController.php',
//        ]);
//    }
}
