<?php

namespace App\Controller;

use App\Entity\RaceMode;
use App\Form\RaceModeType;
use App\Repository\RaceModeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/race/mode')]
final class RaceModeController extends AbstractController
{
    #[Route(name: 'app_race_mode_index', methods: ['GET'])]
    public function index(RaceModeRepository $raceModeRepository): Response
    {
        return $this->render('race_mode/index.html.twig', [
            'race_modes' => $raceModeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_race_mode_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceMode = new RaceMode();
        $form = $this->createForm(RaceModeType::class, $raceMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceMode);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_mode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_mode/new.html.twig', [
            'race_mode' => $raceMode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_mode_show', methods: ['GET'])]
    public function show(RaceMode $raceMode): Response
    {
        return $this->render('race_mode/show.html.twig', [
            'race_mode' => $raceMode,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_race_mode_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceMode $raceMode, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceModeType::class, $raceMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_race_mode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_mode/edit.html.twig', [
            'race_mode' => $raceMode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_mode_delete', methods: ['POST'])]
    public function delete(Request $request, RaceMode $raceMode, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceMode->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceMode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_race_mode_index', [], Response::HTTP_SEE_OTHER);
    }
}
