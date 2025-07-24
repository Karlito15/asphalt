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
final class TagController extends AbstractController
{
    public function __construct(
        private readonly GarageAppRepository $repository,
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('to-unlock-{letter}.php', name: 'to.unlock', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function toUnlock(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.filter.to.unlock');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.to.unlock',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->createDataCache('to.unlock.', $letter, ['where' => 'toUnlock', 'value' => true]),
        ]);
    }

    #[Route('to-upgrade-{letter}.php', name: 'to.upgrade', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function toUpgrade(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.filter.to.upgrade');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.to.upgrade',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->createDataCache('to.upgrade.', $letter, ['where' => 'toUpgrade', 'value' => true]),
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    #[Route('to-gold-{letter}.php', name: 'to.gold', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function toGold(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.filter.to.gold');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.filter.to.gold',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->createDataCache('to.gold.', $letter, ['where' => 'toGold', 'value' => true]),
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
