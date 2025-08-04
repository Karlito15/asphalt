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
final class StatusController extends AbstractController
{
    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly GarageAppRepository $repository,
    ) {}

    #[Route('locked-{letter}.php', name: 'locked', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function locked(Request $request): Response
    {
        $title  = $this->translator->trans('app.page.filter.locked.title');
        $letter = strtoupper($request->attributes->get('letter'));
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

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['level1' => 'Filter', 'level2' => $title],
            'index'           => 'app.page.filter.locked',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->repository->getUnlockedCarsByClass($letter, false),
        ]);
    }

    #[Route('unlock-{letter}.php', name: 'unlock', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function unlock(Request $request): Response
    {
        $title  = $this->translator->trans('app.page.filter.unlock.title');
        $letter = strtoupper($request->attributes->get('letter'));
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

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['level1' => 'Filter', 'level2' => $title],
            'index'           => 'app.page.filter.unlock',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->repository->getUnlockedCarsByClass($letter, true),
        ]);
    }

    #[Route('gold-{letter}.php', name: 'gold', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function gold(Request $request): Response
    {
        $title  = $this->translator->trans('app.page.filter.gold.title');
        $letter = strtoupper($request->attributes->get('letter'));
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

        return $this->render('@App/contents/front/page/filter.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['level1' => 'Filter', 'level2' => $title],
            'index'           => 'app.page.filter.gold',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->repository->getGoldedCarsByClass($letter, true),
//            'results'         => $this->repository->getGarageCondition(['g.gold' => 1], ['g.gameUpdate' => 'ASC']),
        ]);
    }
}
