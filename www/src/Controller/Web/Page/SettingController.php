<?php

namespace App\Controller\Web\Page;

use App\Repository\AppGarageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('{_locale<%app.supported_locales%>}/pages/setting/', name: 'app.page.setting.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
final class SettingController extends AbstractController
{
    public function __construct(
        private readonly AppGarageRepository $garage,
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('blueprint-{letter}.php', name: 'blueprint', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function blueprint(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.setting.blueprint');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/setting/blueprint.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.setting.blueprint',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->garage->getGarageBlueprint($letter),
        ]);
    }

    #[Route('rank-{letter}.php', name: 'rank', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function rank(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.setting.rank');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/setting/rank.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.setting.rank',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->garage->getGarageRank($letter),
        ]);
    }

    #[Route('level-{letter}.php', name: 'level', requirements: ['letter' => Requirement::ASCII_SLUG])]
    public function level(Request $request): Response
    {
        $title  = $this->translator->trans('controllerName.app.page.setting.level');
        $letter = $request->attributes->get('letter');

        return $this->render('@App/app/page/setting/level.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'index'           => 'app.page.setting.level',
            'current'         => $request->attributes->get('_route'),
            'results'         => $this->garage->getGarageUpgrade($letter),
        ]);
    }
}
