<?php

namespace App\Controller\Axios;

use App\Entity\AppInventory;
use App\Repository\AppInventoryRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ajax/dashboard', name: 'ajax.request.', options: ['expose' => true], methods: ['POST'], format: 'json', utf8: true)]
class DashboardController extends AbstractController
{
    private string $message = 'Inventory is saved !';

    public function __construct(
        private readonly AppInventoryRepository $repository,
        private readonly EntityManagerInterface $manager,
        private readonly LoggerInterface $logger,
    ) {}

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/inventory.php', name: 'inventory')]
    public function inventory(Request $request): JsonResponse
    {
        /** Datas */
        $id         = $request->request->get('id');
        $value      = $request->request->get('value');

        /** Find Entity */
        $entity     = $this->repository->findOneBy(['id' => $id]);

        return $this->returnResponse($entity, $value);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/inventory-without-form.php', name: 'inventory.without.form')]
    public function inventoryWithoutForm(Request $request): JsonResponse
    {
        /** init */
        $slug = $value  = '';

        /** Headers */
        $headers    = $request->headers->all();

        /** Datas */
        $r          = $request->request->all();

        /** Find Slug & Value of Input */
        foreach ($r as $k => $v) {
            $slug  = $k;
            $value = $v;
        }

        /** Find Entity */
        $entity     = $this->repository->findOneBy(['slug' => $slug]);

        return $this->returnResponse($entity, $value);

    }

    /**
     * @param AppInventory $entity
     * @param int $value
     * @return int
     * @throws Exception
     */
    private function update(AppInventory $entity, int $value): int
    {
        /** Start Transaction */
        $this->manager->beginTransaction();
        /** Update Entity */
        $entity->setValue($value);
        $this->manager->persist($entity);
        try {
            $this->manager->flush();
            $this->manager->clear();
            $this->manager->getConnection()->commit();
            $status = Response::HTTP_OK;
            $this->addFlash('success', $this->message);
        } catch (\Exception $e) {
            /** Rollback */
            $this->manager->getConnection()->rollBack();
            $status = Response::HTTP_BAD_REQUEST;
            $this->addFlash('error', 'Registration Not Work');
            $this->logger->error($e->getMessage());
        } finally {
            return $status;
        }
    }

    /**
     * @param AppInventory|null $entity
     * @param mixed $value
     * @return JsonResponse
     * @throws Exception
     */
    private function returnResponse(AppInventory|null $entity, mixed $value): JsonResponse
    {
        /** Save Datas */
        if (is_null($entity)) {
            $message    = 'Entity not found';
            $status     = Response::HTTP_BAD_REQUEST;
            $statusText = 'Bad Request';
            $this->addFlash('error', $message);
        } else {
            $status     = $this->update($entity, $value);
            $statusText = 'HTTP_OK';
            $message    = $this->message;
        }

        /** Response */
        return new JsonResponse($message, $status, [], true);
    }
}
