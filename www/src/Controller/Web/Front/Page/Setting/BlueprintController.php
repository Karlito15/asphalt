<?php

namespace App\Controller\Web\Front\Page\Setting;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class BlueprintController extends AbstractController
{
    #[Route('/blueprint', name: 'app_blueprint')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BlueprintController.php',
        ]);
    }
}
