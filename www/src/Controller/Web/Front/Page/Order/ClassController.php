<?php

namespace App\Controller\Web\Front\Page\Order;

use App\Repository\GarageAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/order-by-', name: 'app.page.order.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class ClassController extends AbstractController
{
    #[Route('class-{letter}.php', name: 'class', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function class(Request $request, GarageAppRepository $repository, TranslatorInterface $translator): Response
    {
        $title   = $translator->trans('app.page.order.class.title');
        $letter  = strtoupper($request->attributes->get('letter'));
        $matchLetter = match ($letter) {
            'A' => true,
            'B' => true,
            'C' => true,
            'D' => true,
            'S' => true,
            default => false,
        };

        if (!$matchLetter) {
            throw $this->createNotFoundException('Class Not Found');
        }

        return $this->render('@App/contents/front/page/order.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['level1' => 'Page', 'level2' => $title],
            'current'         => $request->attributes->get('_route'),
            'results'         => $repository->getGarageCondition(['settingClass.value' => $letter], ['g.carOrder' => 'ASC']),
        ]);
    }
}
