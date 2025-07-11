<?php

namespace App\Controller;

use App\Entity\RaceApp;
use App\Form\RaceAppType;
use App\Repository\RaceAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/race/app')]
final class RaceAppController extends AbstractController
{
    #[Route(name: 'app_race_app_index', methods: ['GET'])]
    public function index(RaceAppRepository $raceAppRepository): Response
    {
        return $this->render('race_app/index.html.twig', [
            'race_apps' => $raceAppRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_race_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceApp = new RaceApp();
        $form = $this->createForm(RaceAppType::class, $raceApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceApp);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_app/new.html.twig', [
            'race_app' => $raceApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_app_show', methods: ['GET'])]
    public function show(RaceApp $raceApp): Response
    {
        return $this->render('race_app/show.html.twig', [
            'race_app' => $raceApp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_race_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceApp $raceApp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceAppType::class, $raceApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_race_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_app/edit.html.twig', [
            'race_app' => $raceApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_app_delete', methods: ['POST'])]
    public function delete(Request $request, RaceApp $raceApp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceApp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceApp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_race_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
