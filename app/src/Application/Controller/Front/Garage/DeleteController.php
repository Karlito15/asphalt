<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Garage;

use App\Application\Service\Controller\WebController;
use App\Domain\Entity\GarageApp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/garage',
    name: 'app.garage.',
    requirements: ['id' => Requirement::DIGITS],
    options: ['expose' => false],
    methods: ['POST'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class DeleteController extends AbstractController
{
    use WebController;

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'app.garage.index',
      'create' => 'app.garage.create',
      'read'   => 'app.garage.read',
      'update' => 'app.garage.update',
      'delete' => 'app.garage.delete',
    ];

    #[Route(path: '/delete.php/{id}', name: 'delete')]
    public function delete(
        Request $request,
        GarageApp $entities,
        EntityManagerInterface $manager
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'error',
                message: sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getSettingBrand()->getName() . " " . $entities->getModel())
            );
        }

        return $this->redirectToIndex();
    }
}
