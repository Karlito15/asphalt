<?php

namespace App\Infrastructure\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/front/dashboard', name: 'app_front_dashboard')]
    public function index(): Response
    {
        return $this->render('@App/front/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
