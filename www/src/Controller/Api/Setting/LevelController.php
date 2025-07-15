<?php

namespace App\Controller\Api\Setting;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class LevelController extends AbstractController
{
    #[Route('/level', name: 'app_level')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LevelController.php',
        ]);
    }
}
