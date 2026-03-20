<?php

declare(strict_types=1);

namespace App\Controller\Ajax;

use App\Persistence\Entity\InventoryApp;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: 'ajax/dashboard',
    name: 'ajax.dashboard.',
    options: ['expose' => false],
    methods: ['POST'], // 'GET',
    schemes: ['http', 'https'],
    utf8: true
)] // , format: 'json'
final class DashboardController extends AbstractController
{
    /**
     * @param EntityManagerInterface $manager
     * @param LoggerInterface $logger
     * @param TranslatorInterface $translator
     */
    public function __construct(
		private readonly EntityManagerInterface $manager,
        private readonly LoggerInterface        $logger,
        private readonly TranslatorInterface    $translator,
    ) {}

    /**
     * @throws Exception
     */
    #[Route('/inventory.php', name: 'inventory')]
    public function inventory(Request $request): JsonResponse
    {
        ### Headers
        $request->headers->set('X-API-Version', '1.0');
        // $headers = $request->headers->all();

        ### Request
        $id      = (int) $request->request->get('id');
        $value   = (int) $request->request->get('value');

        ### Find Entity
        $entity  = $this->getEntity($id);

        ### Update Entity
        if (is_null($entity)) {
            $status = $this->entityNotFound();
        } else {
            $status = $this->updateEntity($entity, $value);
        }


        ### Message
        $message = match ($status) {
            200 => $this->getMessageSuccess($entity),
            400 => $this->translator->trans('notification.ajax.not-found'),
            424 => $this->getMessageError(),
        };

        return $this->json($message, $status);//, $headers
    }

    /** PRIVATE METHODS */

    /**
     * Retourne l'entité InventoryApp
     *
     * @param int $id
     * @return InventoryApp|null
     */
    private function getEntity(int $id): ?InventoryApp
    {
        $result = $this->manager->getRepository(InventoryApp::class)->findOneBy(['id' => $id]);
        if ($result instanceof InventoryApp) {
            return $result;
        }

        return null;
    }

    /**
     * @param InventoryApp $entity
     * @param int $value
     * @return int
     * @throws Exception
     */
    private function updateEntity(InventoryApp $entity, int $value): int
    {
        ### Start Transaction
        $this->manager->beginTransaction();

        ### Variables
        $title = $this->translator->trans('text.inventory');

        try {
            ### Flush Entity
            $entity->setValue($value);
            $this->manager->persist($entity);
            $this->manager->flush();
            $this->manager->clear();
            $this->manager->getConnection()->commit();

            ### Return
            $message = $this->getMessageSuccess($entity);
            $status  = Response::HTTP_OK;

            ### Flash Message
//            $this->addFlash('success', [
//                'title' => $title,
//                'message' => $message
//            ]);
            $this->addFlash('success', $message);
        } catch (Exception $e) {
            ### Rollback
            $this->manager->getConnection()->rollBack();
            $this->manager->getConnection()->close();

            ### Return
            $message = $this->getMessageError();
            $status  = Response::HTTP_FAILED_DEPENDENCY;

            ### Flash Message
//            $this->addFlash('error', [
//                'title' => $title,
//                'message' => $message
//            ]);
            $this->addFlash('danger', $e->getMessage());

            ### Logger
            $this->logger->error($e->getMessage());
        }

        return $status;
    }

    /**
     * @return int
     */
    private function entityNotFound(): int
    {
        // Flash Message
//        $this->addFlash('error', [
//            'title' => $this->translator->trans('text.inventory'),
//            'message' => $this->translator->trans('notification.ajax.not-found')
//        ]);
        $this->addFlash('danger', $this->translator->trans('notification.ajax.not-found'));

        return Response::HTTP_BAD_REQUEST;
    }

    /**
     * @param InventoryApp $entity
     * @return string
     */
    private function getMessageSuccess(InventoryApp $entity): string
    {
        return sprintf($this->translator->trans('notification.updated'), $entity->getLabel());
    }

    /**
     * @return string
     */
    private function getMessageError(): string
    {
        return $this->translator->trans('notification.ajax.not-work');
    }
}
