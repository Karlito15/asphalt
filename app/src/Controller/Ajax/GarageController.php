<?php

declare(strict_types=1);

namespace App\Controller\Ajax;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: 'ajax/garage',
    name: 'ajax.garage.',
    options: ['expose' => false],
    methods: ['POST'], // 'GET',
    schemes: ['http', 'https'],
    utf8: true
)] // , format: 'json'
final class GarageController extends AbstractController
{
    #[Route('/garage.php', name: 'garage')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Ajax/DashboardController.php',
        ]);
    }
}
