<?php

namespace App\Controller\Front\Page\Order;

use App\Repository\GarageAppRepository;
use App\Trait\Controller\WebTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/order-by-', name: 'app.page.order.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class EventController extends AbstractController
{
    use WebTrait;

    #[Route('event/class-{letter}.php', name: 'event', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function eventToken(Request $request, GarageAppRepository $repository, TranslatorInterface $translator): Response
    {
        // Variables
        $title  = $translator->trans('text.order.event');
        $letter  = strtoupper($request->attributes->get('letter'));
        $matchLetter = match ($letter) {
            'A' => true,
            'B' => true,
            'C' => true,
            'D' => true,
            'S' => true,
            default => false,
        };

        // Letter Not Match
        $this->return404($matchLetter);

        return $this->render('@App/front/contents/page/order.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $translator->trans('text.order'), 'level2' => $title],
            'entities'        => $repository->getGarageCondition(['settingClass.value' => $letter], ['g.carOrder' => 'DESC'], [0, 5]),
        ]);
    }
}
