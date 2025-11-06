<?php

namespace App\Controller\Front\Page\Setting;

use App\Repository\GarageAppRepository;
use App\Trait\Controller\WebTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    '{_locale<%app.supported_locales%>}/pages/setting/',
    name: 'app.page.setting.',
    requirements: ['letter' => Requirement::ASCII_SLUG],
    options: ['expose' => false],
    defaults: ['letter' => 'S'],
    methods: ['GET'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class BlueprintController extends AbstractController
{
    use WebTrait;

    #[Route('blueprint/class-{letter}.php', name: 'blueprint')]
    public function blueprint(Request $request, GarageAppRepository $repository, TranslatorInterface $translator): Response
    {
        // Variables
        $title       = $translator->trans('text.blueprint');
        $letter      = self::getLetter($request->attributes->get('letter'));
        $matchLetter = self::getControlLetter($letter);
        $entities    = $repository->getGaragePageFilter([
            'status.unblock' => true,
            'status.fullUpgradeSpeed' => false,
            'status.fullUpgradeAcceleration' => false,
            'status.fullUpgradeHandling' => false,
            'status.fullUpgradeNitro' => false,
            'settingClass.value' => $letter,
        ]);

        // Letter Not Match
        if (!$matchLetter) {
            throw $this->createNotFoundException('Class Not Found');
        }

        return $this->render('@App/front/contents/page/setting/blueprint.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $translator->trans('text.filter'), 'level2' => $title],
            'entities'        => $entities,
        ]);
    }
}
