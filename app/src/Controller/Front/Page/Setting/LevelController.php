<?php

namespace App\Controller\Front\Page\Setting;

use App\Repository\GarageAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/pages/setting/', name: 'app.page.setting.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class LevelController extends AbstractController
{
    #[Route('level/class-{letter}.php', name: 'level', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function level(Request $request, GarageAppRepository $garage, TranslatorInterface $translator): Response
    {
        // Variables
        $title   = $translator->trans('text.level');
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

        return $this->render('@App/front/contents/page/setting/level.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $translator->trans('text.filter'), 'level2' => $title],
            'entities'        => $garage->getGaragePageSetting($letter),
        ]);
    }
}
