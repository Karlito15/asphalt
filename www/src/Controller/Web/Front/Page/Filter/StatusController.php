<?php

namespace App\Controller\Web\Front\Page\Filter;

use App\Repository\GarageAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/filter-by-', name: 'app.page.filter.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
//#[Route('/pages/filter-by-', name: 'app.page.filter.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
final class StatusController extends AbstractController
{
    public function __construct(
        private readonly GarageAppRepository $repository,
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('locked-{letter}.php', name: 'locked', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function locked(Request $request): Response
    {
        $title  = $this->translator->trans('app.page.filter.locked');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.locked',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->cacheCreate('locked.', $letter, ['where' => 'locked', 'value' => true]),
        ]);
    }

    #[Route('unlock-{letter}.php', name: 'unlock', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function unlock(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.filter.unlock');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.unlock',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->createDataCache('unlock.', $letter, ['where' => 'locked', 'value' => false]),
        ]);
    }

    #[Route('gold-{letter}.php', name: 'gold', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function gold(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.filter.gold');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.gold',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->createDataCache('gold.', $letter, ['where' => 'gold', 'value' => true]),
        ]);
    }

//    #[Route('/order', name: 'app_order')]
//    public function index(): JsonResponse
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/OrderController.php',
//        ]);
//    }
}
