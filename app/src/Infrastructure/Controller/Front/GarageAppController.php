<?php

namespace App\Infrastructure\Controller\Front;

use App\Infrastructure\Persistence\Entity\GarageApp;
use App\Infrastructure\Persistence\Form\GarageAppType;
use App\Infrastructure\Persistence\Repository\GarageAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/garage/app')]
final class GarageAppController extends AbstractController
{
    #[Route(name: 'app_garage_app_index', methods: ['GET'])]
    public function index(GarageAppRepository $garageAppRepository): Response
    {
        return $this->render('garage_app/index.html.twig', [
            'garage_apps' => $garageAppRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_garage_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $garageApp = new GarageApp();
        $form = $this->createForm(GarageAppType::class, $garageApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($garageApp);
            $entityManager->flush();

            return $this->redirectToRoute('app_garage_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('garage_app/new.html.twig', [
            'garage_app' => $garageApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_garage_app_show', methods: ['GET'])]
    public function show(GarageApp $garageApp): Response
    {
        return $this->render('garage_app/show.html.twig', [
            'garage_app' => $garageApp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_garage_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GarageApp $garageApp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GarageAppType::class, $garageApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_garage_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('garage_app/edit.html.twig', [
            'garage_app' => $garageApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_garage_app_delete', methods: ['POST'])]
    public function delete(Request $request, GarageApp $garageApp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garageApp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($garageApp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_garage_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
