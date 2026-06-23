<?php

declare(strict_types=1);

namespace App\Application\Controller\WWW\Garage;

use App\Domain\Entity\GarageApp;
use App\Infrastructure\Abstract\Controller\AbstractBaseController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

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
final class DeleteController extends AbstractBaseController
{
    /** @description link to pages */
    public static array $crud = [
        'index'  => 'app.garage.index',
        'create' => 'app.garage.create',
        'read'   => 'app.garage.read',
        'update' => 'app.garage.update',
        'delete' => 'app.garage.delete',
    ];

    #[Route(path: '/delete.php/{id}', name: 'delete')]
    public function delete(
        EntityManagerInterface $manager,
        GarageApp $entities,
        Request $request,
        TranslatorInterface $translator
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            ### Variables
            $message = sprintf(
                $translator->trans('notification.deleted'),
                $entities->getId(),
                $entities->getSettingBrand()->getName() . " " . $entities->getModel()
            );

            ### Doctrine
            $manager->remove($entities);
            $manager->flush();
            $manager->clear();

            ### Flash Message
            $this->addFlash(type:'error', message: $message);
        }

        ### Redirection
        return $this->redirectToRoute(self::$crud['index'], [], Response::HTTP_SEE_OTHER);
    }
}
