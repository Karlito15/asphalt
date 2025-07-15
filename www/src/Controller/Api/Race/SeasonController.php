<?php

namespace App\Controller\Api\Race;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class SeasonController extends AbstractController
{
    #[Route('/season', name: 'app_season')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SeasonController.php',
        ]);
    }
}
