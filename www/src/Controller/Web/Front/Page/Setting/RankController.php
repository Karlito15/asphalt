<?php

namespace App\Controller\Web\Front\Page\Setting;

use App\Repository\GarageAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/setting/', name: 'app.page.setting.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class RankController extends AbstractController
{
    #[Route('rank-{letter}.php', name: 'rank', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function rank(Request $request, GarageAppRepository $garage, TranslatorInterface $translator): Response
    {
        $title   = $translator->trans('app.page.setting.rank.title');
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

        return $this->render('@App/contents/front/page/setting-rank.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['level1' => 'Page', 'level2' => $title],
            'index'           => 'app.page.setting.rank',
            'current'         => $request->attributes->get('_route'),
            'results'         => $garage->getGaragePageSetting($letter),
        ]);
    }
}
