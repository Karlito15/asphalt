<?php

namespace App\Controller\Api\Race;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('{_locale<%app.supported_locales%>}/api/race/mode', name: 'api.race.mode.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class ModeController extends AbstractController
{
    #[Route('/index', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ModeController.php',
        ]);
    }
}
