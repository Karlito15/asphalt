<?php

namespace App\Controller\Ajax;

use App\Entity\InventoryApp;
use App\Service\Cache\DashboardService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('ajax/dashboard', name: 'ajax.dashboard.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class DashboardController extends AbstractController
{
    /**
     * @param DashboardService $cacheService
     * @param EntityManagerInterface $manager
     * @param LoggerInterface $logger
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/index.php', name: 'index', methods: ['POST'])]
	public function index(
        DashboardService $cacheService,
		EntityManagerInterface $manager,
		LoggerInterface $logger,
		Request $request,
    ): JsonResponse
	{
		/** variables */
        $headers = $request->headers->all();
		$datas   = $request->request->all();
		$slug    = array_keys($datas)[0];
		$value   = $datas[$slug];

		/** Find Entity */
		$entity  = $manager->getRepository(InventoryApp::class)->findOneBy(['slug' => $slug]);

		/** Save Datas */
		if (is_null($entity)) {
			$message = 'Entity not found';
			$status  = Response::HTTP_BAD_REQUEST;
			$this->addFlash('error', $message);
		} else {
            /** Start Transaction */
            $manager->beginTransaction();
            $entity->setValue($value);
            $manager->persist($entity);
            /** Update Entity */
            try {
                $manager->flush();
                $manager->clear();
                $manager->getConnection()->commit();
                $status  = Response::HTTP_OK;
                $message = 'Inventory is saved !';
                $this->addFlash('success', $message);
            } catch (\Exception $e) {
                $manager->getConnection()->rollBack();
                $logger->error($e->getMessage());
                $message = 'Registration Not Work';
                $status = Response::HTTP_BAD_REQUEST;
                $this->addFlash('error', $message);
            }
		}

        /** Delete Cache */
        $cacheService->cacheDelete();

		return $this->json($message, $status, $headers, []);
	}
}
