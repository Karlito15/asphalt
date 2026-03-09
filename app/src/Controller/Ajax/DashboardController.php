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

    #[Route('/inventory.php', name: 'inventory')]
    public function inventory(Request $request): JsonResponse
    {
		// Variables
        $headers = $request->headers->all();
		$datas   = $request->request->all();
		$id      = $datas['id'];
		$value   = $datas['value'];
//		$slug    = array_keys($datas)[0];

        // Find Entity
//      $entity  = $this->manager->getRepository(InventoryApp::class)->findOneBy(['slug' => $slug]);
        $entity  = $this->manager->getRepository(InventoryApp::class)->findOneBy(['id' => $id]);
        if (is_null($entity)) {
            $status = $this->entityNotFound();
        } else {
            $status = $this->updateEntity($entity, $value);
        }

        // Delete Cache
//        $service->cacheDelete();

        // Message
        $message = match ($status) {
            200 => $this->getMessageSuccess($entity),
            400 => $this->translator->trans('notification.ajax.not-found'),
            424 => $this->translator->trans('notification.ajax.not-work'),
        };

        return $this->json($message, $status, $headers);
    }

    /**
     * @param InventoryApp $entity
     * @param int $value
     * @return int
     * @throws Exception
     */
    private function updateEntity(InventoryApp $entity, int $value): int
    {
        // Variables
        $title = $this->translator->trans('text.inventory');

        // Start Transaction
        $this->manager->beginTransaction();

        // Update Entity
        $entity->setValue($value);
        $this->manager->persist($entity);

        try {
            // Flush Entity
            $this->manager->flush();
            $this->manager->clear();
            $this->manager->getConnection()->commit();
            $message = $this->getMessageSuccess($entity);
            $status  = Response::HTTP_OK;

            // Flash Message
            $this->addFlash('success', [
                'title' => $title,
                'message' => $message
            ]);
        } catch (Exception $e) {
            // Roll Back
            $this->manager->getConnection()->rollBack();
            $message = $this->translator->trans('notification.ajax.not-work');
            $status  = Response::HTTP_FAILED_DEPENDENCY;

            // Flash Message
            $this->addFlash('error', [
                'title' => $title,
                'message' => $message
            ]);

            // Logger
            $this->logger->error($e->getMessage());
            echo $e->getMessage();
        }

        return $status;
    }

    /**
     * @return int
     */
    private function entityNotFound(): int
    {
        // Flash Message
        $this->addFlash('error', [
            'title' => $this->translator->trans('text.inventory'),
            'message' => $this->translator->trans('notification.ajax.not-found')
        ]);

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
}
