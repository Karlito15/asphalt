<?php

namespace App\Controller\Front;

use App\Service\Cache\RaceAppService;
use App\Trait\Controller\WebTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/race', name: 'app.race.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class RaceAppController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index = 'app.race.index';

    /** @description link to the create page */
    private static string $create = 'admin.race.create';

    /** @description link to the delete page */
    private static string $delete = 'admin.race.delete';

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(
        Request $request,
        RaceAppService $service,
        TranslatorInterface $translator,
    ): Response
    {
        // Variables
        $title = $translator->trans('text.all.races');

        return $this->render('@App/front/contents/race.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container-fluid',
            'breadcrumb'      => ['level1' => $translator->trans('text.race'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'entities'        => $service->cacheCreate(),
        ]);
    }
}
