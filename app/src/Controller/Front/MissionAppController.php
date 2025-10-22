<?php

namespace App\Controller\Front;

use App\Service\Cache\MissionAppService;
use App\Trait\Controller\WebTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/mission', name: 'app.mission.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class MissionAppController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index    = 'app.mission.index';

    /** @description link to the create page */
    private static string $create   = 'admin.mission.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.mission.delete';

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(
        Request $request,
        MissionAppService $service,
        TranslatorInterface $translator
    ): Response
    {
        // Variables
        $title = $translator->trans('text.all.missions');

        return $this->render('@App/front/contents/mission.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $translator->trans('text.mission'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'entities'        => $service->cacheCreate(),
        ]);
    }
}
