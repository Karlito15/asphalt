<?php

namespace App\Controller\Web\Front\Garage;

use App\Able\Controller\WebAble;
use App\Entity\GarageApp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/garage', name: 'app.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class ReadController extends AbstractController
{
    use WebAble;

    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /** @description link to the create page */
    private static string $create = 'app.garage.create';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/read/{slug}-{id}.php', name: 'read', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET'])]
    public function read(Request $request, GarageApp $entity): Response
    {
        $car   = $entity->getSettingBrand()->getName() . " " . $entity->getModel();
        $title = $this->translator->trans('app.garage.read.title') . $car;

        return $this->render('@App/contents/front/garage/read.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'XXXX', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entity'            => $entity,
        ]);
    }
}
