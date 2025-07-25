<?php

namespace App\Controller\Web\Front\Page\Order;

use App\Repository\GarageAppRepository;
use App\Repository\SettingClassRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/order-by-', name: 'app.page.order.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class StatController extends AbstractController
{
    public function __construct(
        private readonly GarageAppRepository $garage,
        private readonly SettingClassRepository $class,
        private readonly TranslatorInterface $translator
    ) {}

    #[Route('stat-{letter}.php', name: 'stat', requirements: ['letter' => Requirement::ASCII_SLUG], methods: ['GET'])]
    public function stat(Request $request): Response
    {
        $title   = $this->translator->trans('controllerName.app.page.order.stat');
        $letter  = $request->attributes->get('letter');
        $class   = $this->class->findOneBy(['value' => $letter]);

        return $this->render('@App/contents/front/page/order.html.twig', [
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
