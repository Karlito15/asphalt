<?php

namespace App\Controller\Web\Front\Page\Order;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('{_locale<%app.supported_locales%>}/pages/order-by-', name: 'app.page.order.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
final class EventController extends AbstractController
{
    public function __construct(
        private readonly AppGarageRepository $garage,
        private readonly SettingClassRepository $class,
        private readonly TranslatorInterface $translator
    ) {}

    #[Route('event-{letter}.php', name: 'event', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function eventToken(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.order.event');
        $letter = $request->attributes->get('letter');
        $class  = $this->class->findBy(['value'  => $letter]);

        switch ($letter):
//            case 'A':
//                $result = $garage->findBy(['settingClass'  => $class], ['carOrder' => 'DESC'], 5, 1);
//                break;
//            case 'S':
//                $result = $garage->findBy(['settingClass'  => $class], ['carOrder' => 'DESC'], 5, 3);
//                break;
            default;
                $result = $this->garage->findBy(['settingClass'  => $class], ['carOrder' => 'DESC'], 5);
                break;
        endswitch;

        return $this->render('@App/app/page/order.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'current'         => $request->attributes->get('_route'),
            'results'         => $result,
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
