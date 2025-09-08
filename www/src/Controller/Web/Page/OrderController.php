<?php

namespace App\Controller\Web\Page;

use App\Repository\AppGarageRepository;
use App\Repository\SettingClassRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/order-by-', name: 'app.page.order.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
class OrderController extends AbstractController
{
    public function __construct(
        private readonly AppGarageRepository $garage,
        private readonly SettingClassRepository $class,
        private readonly TranslatorInterface $translator
    ) {}

    #[Route('class-{letter}.php', name: 'class', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function class(Request $request): Response
    {
        $title   = $this->translator->trans('controllerName.app.page.order.class');
        $letter  = $request->attributes->get('letter');
        $class   = $this->class->findOneBy(['value' => $letter]);

        return $this->render('@App/app/page/order.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->garage->findBy(['settingClass'  => $class], ['carOrder' => 'ASC']),
        ]);
    }

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
}
