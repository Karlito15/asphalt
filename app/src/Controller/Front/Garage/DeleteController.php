<?php

declare(strict_types=1);

namespace App\Controller\Front\Garage;

use App\Persistence\Entity\GarageApp;
use App\Toolbox\Trait\Controller\WebController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/garage',
    name: 'app.garage.',
    options: ['expose' => false],
    methods: ['POST'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class DeleteController extends AbstractController
{
    use WebController;

    /**
     * Supprime une voiture du Garage
     *
     * @param Request $request
     * @param GarageApp $garage
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @return Response
     */
    #[Route(path: 'delete.php/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete(
        Request $request,
        GarageApp $garage,
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garage->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($garage);
            $entityManager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $translator->trans('text.garage'),
                'message' => sprintf($translator->trans('notification.deleted'),
                    $garage->getSettingBrand()->getName() . " " . $garage->getModel()
                )
            ]);
        }

        return $this->redirectToIndex();
    }
}
