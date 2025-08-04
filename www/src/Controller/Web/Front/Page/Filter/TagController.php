<?php

namespace App\Controller\Web\Front\Page\Filter;

use App\Repository\GarageAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/filter-by-', name: 'app.page.filter.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class TagController extends AbstractController
{
    public function __construct(
        private readonly GarageAppRepository $repository,
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('to-unlock-{letter}.php', name: 'to.unlock', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function toUnlock(Request $request): Response
    {
        $title  = $this->translator->trans('app.page.tag.to.unlock');
        $letter  = strtoupper($request->attributes->get('letter'));

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['level1' => 'Filter', 'level2' => $title],
            'index'           => 'app.page.filter.to.unlock',
            'current'         => $request->attributes->get('_route'),
//            'results'         => $this->cacheCreate('to.unlock.', $letter, ['where' => 'toUnlock', 'value' => true]),
            'results'         => [],
        ]);
    }

    #[Route('to-upgrade-{letter}.php', name: 'to.upgrade', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function toUpgrade(Request $request): Response
    {
        $title  = $this->translator->trans('app.page.tag.to.upgrade');
        $letter  = strtoupper($request->attributes->get('letter'));

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['level1' => 'Filter', 'level2' => $title],
            'index'           => 'app.page.filter.to.upgrade',
            'current'         => $request->attributes->get('_route'),
//            'results'         => $this->cacheCreate('to.upgrade.', $letter, ['where' => 'toUpgrade', 'value' => true]),
            'results'         => [],
        ]);
    }

    #[Route('to-gold-{letter}.php', name: 'to.gold', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function toGold(Request $request): Response
    {
        $title  = $this->translator->trans('app.page.tag.to.gold');
        $letter  = strtoupper($request->attributes->get('letter'));

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['level1' => 'Filter', 'level2' => $title],
            'index'           => 'app.page.filter.to.gold',
            'current'         => $request->attributes->get('_route'),
//            'results'         => $this->cacheCreate('to.gold.', $letter, ['where' => 'toGold', 'value' => true]),
            'results'         => [],
        ]);
    }
}
