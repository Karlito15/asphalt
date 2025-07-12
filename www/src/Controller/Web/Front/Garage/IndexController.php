<?php

namespace App\Controller\Web\Front\Garage;

use App\Able\Controller\WebAble;
use App\Repository\GarageAppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/garage', name: 'app.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class IndexController extends AbstractController
{
    use WebAble;

    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /** @description link to the create page */
    private static string $create = 'app.garage.create';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    /**
     * @param Request $request
     * @param GarageAppRepository $repository
     * @return Response
     */
    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, GarageAppRepository $repository): Response
    {
        $title = $this->translator->trans('app.garage.index.title');

        return $this->render('@App/contents/front/garage/index.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => $title,
            'links'             => self::getLinksPage(),
            'entities'          => $repository->findBy([], ['gameUpdate' => 'DESC']),
        ]);
    }
}
