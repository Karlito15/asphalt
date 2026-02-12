<?php

namespace App\Controller\Front;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Form\GarageAppType;
use App\Persistence\Repository\GarageAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/garage',
    name: 'app.garage.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class GarageAppController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(GarageAppRepository $garageAppRepository): Response
    {
        return $this->render('garage_app/index.html.twig', [
            'garage_apps' => $garageAppRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(GarageApp $garageApp): Response
    {
        return $this->render('garage_app/show.html.twig', [
            'garage_app' => $garageApp,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, GarageApp $garageApp, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, GarageApp $garageApp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garageApp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($garageApp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_garage_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
