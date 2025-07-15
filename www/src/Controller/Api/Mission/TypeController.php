<?php

namespace App\Controller\Api\Mission;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class TypeController extends AbstractController
{
    #[Route('/type', name: 'app_type')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TypeController.php',
        ]);
    }
}
