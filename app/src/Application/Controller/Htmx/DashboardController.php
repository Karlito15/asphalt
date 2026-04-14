<?php

declare(strict_types=1);

namespace App\Application\Controller\Htmx;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: 'ajax/dashboard',
    name: 'ajax.dashboard.',
    options: ['expose' => false],
    methods: ['POST'], // 'GET',
    schemes: ['http', 'https'],
//    format: 'json',
    utf8: true
)]
final class DashboardController extends AbstractController
{
    #[Route('/inventory.php', name: 'inventory')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Htmx/DashboardController.php',
        ]);
    }
}
