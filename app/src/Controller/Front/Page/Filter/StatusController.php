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

#[Route(
    '{_locale<%app.supported_locales%>}/pages/filter-by-',
    name: 'app.page.filter.',
    requirements: ['letter' => Requirement::ASCII_SLUG],
    options: ['expose' => false],
    defaults: ['letter' => 'S'],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class StatusController extends AbstractController
{
    use WebTrait;

    public function __construct(
        private readonly GarageAppRepository $repository,
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('unblock/class-{letter}.php', name: 'unblock')]
    public function unblock(Request $request): Response
    {
        // Variables
        $title       = $this->translator->trans('text.unblock');
        $letter      = self::getLetter($request->attributes->get('letter'));
        $matchLetter = self::getControlLetter($letter);
        $entities    = $this->repository->getGaragePageFilter([
            'status.unblock' => true,
            'settingClass.value' => $letter,
        ]);

        // Letter Not Match
        $this->return404($matchLetter);

        return $this->render('@App/front/contents/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.filter'), 'level2' => $title],
            'entities'        => $entities,
        ]);
    }

    #[Route('block/class-{letter}.php', name: 'block')]
    public function block(Request $request): Response
    {
        // Variables
        $title       = $this->translator->trans('text.block');
        $letter      = self::getLetter($request->attributes->get('letter'));
        $matchLetter = self::getControlLetter($letter);
        $entities    = $this->repository->getGaragePageFilter([
            'status.unblock' => false,
            'settingClass.value' => $letter,
        ]);

        // Letter Not Match
        $this->return404($matchLetter);

        return $this->render('@App/front/contents/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.filter'), 'level2' => $title],
            'entities'        => $entities,
        ]);
    }

    #[Route('to-unblock/class-{letter}.php', name: 'to.unblock')]
    public function toUnblock(Request $request): Response
    {
        // Variables
        $title       = $this->translator->trans('text.to.unblock');
        $letter      = self::getLetter($request->attributes->get('letter'));
        $matchLetter = self::getControlLetter($letter);
        $entities    = $this->repository->getGaragePageFilter([
            'status.unblock' => false,
            'status.toUnblock' => true,
            'settingClass.value' => $letter,
        ]);

        // Letter Not Match
        $this->return404($matchLetter);

        return $this->render('@App/front/contents/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.filter'), 'level2' => $title],
            'entities'        => $entities,
        ]);
    }

    #[Route('gold/class-{letter}.php', name: 'gold')]
    public function gold(Request $request): Response
    {
        // Variables
        $title       = $this->translator->trans('text.gold');
        $letter      = self::getLetter($request->attributes->get('letter'));
        $matchLetter = self::getControlLetter($letter);
        $entities    = $this->repository->getGaragePageFilter([
            'status.unblock' => true,
            'status.gold' => true,
            'settingClass.value' => $letter,
        ]);

        // Letter Not Match
        $this->return404($matchLetter);

        return $this->render('@App/front/contents/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.filter'), 'level2' => $title],
            'entities'        => $entities,
        ]);
    }

    #[Route('to-gold/class-{letter}.php', name: 'to.gold')]
    public function toGold(Request $request): Response
    {
        // Variables
        $title       = $this->translator->trans('text.to.gold');
        $letter      = self::getLetter($request->attributes->get('letter'));
        $matchLetter = self::getControlLetter($letter);
        $entities    = $this->repository->getGaragePageFilter([
            'status.unblock' => true,
            'status.toGold' => true,
            'settingClass.value' => $letter,
        ]);

        // Letter Not Match
        $this->return404($matchLetter);

        return $this->render('@App/front/contents/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.filter'), 'level2' => $title],
            'entities'        => $entities,
        ]);
    }

    #[Route('to-upgrade/class-{letter}.php', name: 'to.upgrade')]
    public function toUpgrade(Request $request): Response
    {
        // Variables
        $title       = $this->translator->trans('text.to.upgrade');
        $letter      = self::getLetter($request->attributes->get('letter'));
        $matchLetter = self::getControlLetter($letter);
        $entities    = $this->repository->getGaragePageFilter([
            'status.unblock' => true,
            'status.toUpgradeLevel' => true,
            'settingClass.value' => $letter,
        ]);

        // Letter Not Match
        $this->return404($matchLetter);

        return $this->render('@App/front/contents/page/filter.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.filter'), 'level2' => $title],
            'entities'        => $entities,
        ]);
    }
}
