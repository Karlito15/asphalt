<?php

namespace App\Controller\Web\Front\Page\Setting;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('{_locale<%app.supported_locales%>}/pages/setting/', name: 'app.page.setting.', options: ['expose' => false], methods: ['GET'], format: 'html', utf8: true)]
final class BlueprintController extends AbstractController
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
//    #[Route('/blueprint', name: 'app_blueprint')]
//    public function index(): JsonResponse
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/BlueprintController.php',
//        ]);
//    }
}
