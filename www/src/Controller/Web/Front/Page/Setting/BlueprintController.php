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
final class BlueprintController extends AbstractController
{
    #[Route('blueprint-{letter}.php', name: 'blueprint', requirements: ['letter' => Requirement::ASCII_SLUG], defaults: ['letter' => 'S'], methods: ['GET'])]
    public function blueprint(Request $request, GarageAppRepository $garage, TranslatorInterface $translator): Response
    {
        $title   = $translator->trans('app.page.setting.blueprint.title');
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

        return $this->render('@App/contents/front/page/setting-blueprint.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['level1' => 'Page', 'level2' => $title],
            'index'           => 'app.page.setting.blueprint',
            'current'         => $request->attributes->get('_route'),
            'results'         => $garage->getGaragePageSetting($letter),
        ]);
    }
}
