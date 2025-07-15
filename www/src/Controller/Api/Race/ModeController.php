<?php

namespace App\Controller\Api\Race;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ModeController extends AbstractController
{
    #[Route('/mode', name: 'app_mode')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ModeController.php',
        ]);
    }
}
