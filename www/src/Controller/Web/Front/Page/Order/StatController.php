<?php

namespace App\Controller\Web\Front\Page\Order;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('{_locale<%app.supported_locales%>}/pages/order-by-', name: 'app.page.order.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
final class StatController extends AbstractController
{
    public function __construct(
        private readonly AppGarageRepository $garage,
        private readonly SettingClassRepository $class,
        private readonly TranslatorInterface $translator
    ) {}

    #[Route('stat-{letter}.php', name: 'stat', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function stat(Request $request): Response
    {
        $title   = $this->translator->trans('controllerName.app.page.order.stat');
        $letter  = $request->attributes->get('letter');
        $class   = $this->class->findOneBy(['value' => $letter]);

        return $this->render('@App/app/page/order.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->garage->findBy(['settingClass'  => $class], ['statOrder' => 'ASC']),
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
