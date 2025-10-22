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
final class StatusController extends AbstractController
{
    use WebTrait;

    public function __construct(
        private readonly GarageAppRepository $repository,
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('locked/class-{letter}.php', name: 'locked', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function locked(Request $request): Response
    {
        // Variables
        $title  = $this->translator->trans('text.locked');
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
            'entities'        => $this->repository->getUnlockedCarsByClass($letter, false),
        ]);
    }

    #[Route('unlock/class-{letter}.php', name: 'unlock', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function unlock(Request $request): Response
    {
        // Variables
        $title  = $this->translator->trans('text.unlock');
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
            'entities'        => $this->repository->getUnlockedCarsByClass($letter, true),
        ]);
    }

    #[Route('gold/class-{letter}.php', name: 'gold', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function gold(Request $request): Response
    {
        // Variables
        $title  = $this->translator->trans('text.gold');
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
            'entities'        => $this->repository->getGoldedCarsByClass($letter, true),
//            'entities'           => $this->repository->getGarageCondition(['g.gold' => 1], ['g.gameUpdate' => 'ASC']),
        ]);
    }
}
