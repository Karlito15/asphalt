<?php

namespace App\Controller\Front\Garage;

use App\Entity\GarageApp;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/garage', name: 'app.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class ReadController extends AbstractController
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
     * @param EntityManagerInterface $manager
     * @param TranslatorInterface $translator
     * @param int $id
     * @param string $slug
     * @return Response
     */
    #[Route('/read/{slug}-{id}.php', name: 'read', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET'])]
    public function read(
        Request $request,
        EntityManagerInterface $manager,
        TranslatorInterface $translator,
        int $id,
        string $slug
    ): Response
    {
        // Entity
        $entity = $manager->getRepository(GarageApp::class)->getGarageOne($id, $slug);

        // Variables
        $title = $entity['brand'] . ' ' . $entity['model'];

        return $this->render('@App/front/contents/garage/read.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $translator->trans('text.garage'), 'level2' => $translator->trans('text.read')],
            'links'           => self::getLinksPage(),
            'entity'          => $entity,
            'car'             => $title,
        ]);
    }
}
