<?php

namespace App\Controller\Api\Mission;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('{_locale<%app.supported_locales%>}/api/mission/type', name: 'api.mission.type.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class TypeController extends AbstractController
{
    #[Route('/index', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TypeController.php',
        ]);
    }
}
