<?php

namespace App\Controller\Front\Page\Filter;

use App\Repository\GarageAppRepository;
use App\Trait\Controller\WebTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/filter-by-', name: 'app.page.filter.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class TagController extends AbstractController
{
    use WebTrait;

    public function __construct(
        private readonly GarageAppRepository $repository,
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('to-unlock/class-{letter}.php', name: 'to.unlock', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function toUnlock(Request $request): Response
    {
        // Variables
        $title  = $this->translator->trans('text.to.unblock');
        $letter = strtoupper($request->attributes->get('letter'));
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

        return $this->render('@App/front/contents/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.filter'), 'level2' => $title],
            'entities'        => [],
//            'entities'         => $this->cacheCreate('to.unlock.', $letter, ['where' => 'toUnlock', 'value' => true]),
        ]);
    }

    #[Route('to-upgrade/class-{letter}.php', name: 'to.upgrade', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function toUpgrade(Request $request): Response
    {
        // Variables
        $title  = $this->translator->trans('text.to.upgrade');
        $letter = strtoupper($request->attributes->get('letter'));
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

        return $this->render('@App/front/contents/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.filter'), 'level2' => $title],
            'entities'        => [],
//            'entities'         => $this->cacheCreate('to.upgrade.', $letter, ['where' => 'toUpgrade', 'value' => true]),
        ]);
    }

    #[Route('to-gold/class-{letter}.php', name: 'to.gold', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function toGold(Request $request): Response
    {
        // Variables
        $title  = $this->translator->trans('text.to.gold');
        $letter = strtoupper($request->attributes->get('letter'));
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

        return $this->render('@App/front/contents/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.filter'), 'level2' => $title],
            'entities'        => [],
//            'entities'         => $this->cacheCreate('to.gold.', $letter, ['where' => 'toGold', 'value' => true]),
        ]);
    }
}
