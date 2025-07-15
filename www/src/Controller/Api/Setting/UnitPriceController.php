<?php

namespace App\Controller\Api\Setting;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UnitPriceController extends AbstractController
{
    #[Route('/unit/price', name: 'app_unit_price')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UnitPriceController.php',
        ]);
    }
}
