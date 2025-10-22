<?php

namespace App\Controller\Ajax;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('ajax/garage', name: 'ajax.garage.', options: ['expose' => false], methods: ['POST'], schemes: ['http', 'https'], format: 'json', utf8: true)]
final class GarageUpdateController extends AbstractController
{
    #[Route('/update.php', name: 'update')]
    public function update(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UpdateController.php',
        ]);
    }







    #[Route('/blueprint/{id}', name: 'api_axios_blueprint', requirements: ['id' => Requirement::DIGITS])]
    public function blueprint(
		Request $request,
		EntityManagerInterface $manager,
    ): JsonResponse
    {
        /** Headers */
        $headers = $request->headers->all();

        return $this->json([], Response::HTTP_OK, $headers, []);
    }

    #[Route('/rank/{id}', name: 'api_axios_rank', requirements: ['id' => Requirement::DIGITS])]
    public function rank(
		Request $request,
		EntityManagerInterface $manager,
    ): JsonResponse
    {
        /** Headers */
        $headers = $request->headers->all();

        return $this->json([], Response::HTTP_OK, $headers, []);
    }

    #[Route('/upgrade/{id}', name: 'api_axios_upgrade', requirements: ['id' => Requirement::DIGITS])]
    public function upgrade(
		Request $request,
		EntityManagerInterface $manager,
    ): JsonResponse
    {
        /** Headers */
        $headers = $request->headers->all();

        return $this->json([], Response::HTTP_OK, $headers, []);
    }
}
