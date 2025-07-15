<?php

namespace App\Controller\Api\Race;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class TrackController extends AbstractController
{
    #[Route('/track', name: 'app_track')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TrackController.php',
        ]);
    }
}
