<?php

namespace App\Controller\Front;

use App\Service\Cache\GarageAppService;
use App\Trait\Controller\WebTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/garage', name: 'app.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class GarageAppController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /** @description link to the create page */
    private static string $create = 'app.garage.create';

    /** @description link to the delete page */
    private static string $delete = 'app.garage.delete';

    /**
     * @param Request $request
     * @param GarageAppService $service
     * @param TranslatorInterface $translator
     * @return Response
     */
    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(
        Request $request,
        GarageAppService $service,
        TranslatorInterface $translator,
    ): Response
    {
        // Variables
        $title = $translator->trans('text.all.cars');

        return $this->render('@App/front/contents/garage/index.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $translator->trans('text.garage'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'entities'        => $service->cacheCreate(),
        ]);
    }
}
