<?php

namespace App\Controller\Ajax\Garage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('{_locale<%app.supported_locales%>}/ajax/garage', name: 'ajax.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class UpdateController extends AbstractController
{
    #[Route('/update.php', name: 'update', methods: ['POST'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UpdateController.php',
        ]);
    }
}
