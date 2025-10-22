<?php

namespace App\Controller\Ajax;

use App\Entity\InventoryApp;
use App\Service\Cache\DashboardService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('ajax/dashboard', name: 'ajax.dashboard.', options: ['expose' => false], schemes: ['http', 'https'], utf8: true)] // , format: 'json', utf8: true
final class DashboardController extends AbstractController
{
    /**
     * @param EntityManagerInterface $manager
     * @param TranslatorInterface $translator
     */
    public function __construct(
		private readonly EntityManagerInterface $manager,
        private readonly TranslatorInterface $translator,
    ) {}

    /**
     * @param DashboardService $service
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/inventory.php', name: 'inventory', methods: ['GET', 'POST'])]
	public function inventory(
        DashboardService $service,
		Request $request,
    ): JsonResponse
	{
		// Variables
        $headers = $request->headers->all();
		$datas   = $request->request->all();
		$slug    = array_keys($datas)[0];
		$id      = $datas['id'];
		$value   = $datas['value'];

		// Find Entity
//		$entity  = $this->manager->getRepository(InventoryApp::class)->findOneBy(['slug' => $slug]);
		$entity  = $this->manager->getRepository(InventoryApp::class)->findOneBy(['id' => $id]);
		if (is_null($entity)) {
            $status = $this->entityNotFound();

		} else {
            $status = $this->updateEntity($entity, $value);
		}

        // Delete Cache
        $service->cacheDelete();

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
    private function updateEntity(
        InventoryApp $entity,
        int $value,
    ): int
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
            $status = Response::HTTP_OK;

            // Flash Message
            $this->addFlash('success', [
                'title' => $title,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            // Roll Back
            $this->manager->getConnection()->rollBack();
            $message = $this->translator->trans('notification.ajax.not-work');
            $status = Response::HTTP_FAILED_DEPENDENCY;

            // Logger
            // $this->logger->error($e->getMessage());
            echo $e->getMessage();

            // Flash Message
            $this->addFlash('error', [
                'title' => $title,
                'message' => $message
            ]);
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
