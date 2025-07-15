<?php

namespace App\Controller\Ajax\Garage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UpdateController extends AbstractController
{
    #[Route('/update', name: 'app_update')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UpdateController.php',
        ]);
    }
}
