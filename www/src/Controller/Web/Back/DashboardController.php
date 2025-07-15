<?php

namespace App\Controller\Web\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'app.dashboard.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class DashboardController extends AbstractController
{
    private static string $page = 'Dashboard';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route(path: '{_locale<%app.supported_locales%>}/admin.php', name: 'admin')]
    public function admin(): Response
    {
        $title = $this->translator->trans('app.dashboard.admin.title');

        return $this->render('@App/contents/back/dashboard/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => $title,
            'inventory'       => ['title' => $this->translator->trans('app.inventory.index.title'), 'link' => 'app.inventory.index'],
            'missions'        => [
                'task' => ['title' => $this->translator->trans('app.mission.task.index.title'), 'link' => 'app.mission.task.index'],
                'type' => ['title' => $this->translator->trans('app.mission.type.index.title'), 'link' => 'app.mission.type.index'],
            ],
            'races'           => [
                'mode' => ['title' => $this->translator->trans('app.race.mode.index.title'), 'link' => 'app.race.mode.index'],
                'region' => ['title' => $this->translator->trans('app.race.region.index.title'), 'link' => 'app.race.region.index'],
                'season' => ['title' => $this->translator->trans('app.race.season.index.title'), 'link' => 'app.race.season.index'],
                'time' => ['title' => $this->translator->trans('app.race.time.index.title'), 'link' => 'app.race.time.index'],
                'time' => ['title' => $this->translator->trans('app.race.track.index.title'), 'link' => 'app.race.track.index'],
            ],
            'settings'        => [
                'blueprint' => ['title' =>$this->translator->trans('app.setting.blueprint.index.title'), 'link' => 'app.setting.blueprint.index'],
                'brand' => ['title' =>$this->translator->trans('app.setting.brand.index.title'), 'link' => 'app.setting.brand.index'],
                'class' => ['title' =>$this->translator->trans('app.setting.class.index.title'), 'link' => 'app.setting.class.index'],
                'level' => ['title' =>$this->translator->trans('app.setting.level.index.title'), 'link' => 'app.setting.level.index'],
                'tag' => ['title' =>$this->translator->trans('app.setting.tag.index.title'), 'link' => 'app.setting.tag.index'],
                'unit-price' => ['title' =>$this->translator->trans('app.setting.unit-price.index.title'), 'link' => 'app.setting.unit-price.index'],
            ],
        ]);
    }
}
