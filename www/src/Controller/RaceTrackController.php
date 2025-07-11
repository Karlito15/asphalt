<?php

namespace App\Controller;

use App\Entity\RaceTrack;
use App\Form\RaceTrackType;
use App\Repository\RaceTrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/race/track')]
final class RaceTrackController extends AbstractController
{
    #[Route(name: 'app_race_track_index', methods: ['GET'])]
    public function index(RaceTrackRepository $raceTrackRepository): Response
    {
        return $this->render('race_track/index.html.twig', [
            'race_tracks' => $raceTrackRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_race_track_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceTrack = new RaceTrack();
        $form = $this->createForm(RaceTrackType::class, $raceTrack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceTrack);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_track_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_track/new.html.twig', [
            'race_track' => $raceTrack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_track_show', methods: ['GET'])]
    public function show(RaceTrack $raceTrack): Response
    {
        return $this->render('race_track/show.html.twig', [
            'race_track' => $raceTrack,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_race_track_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceTrack $raceTrack, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceTrackType::class, $raceTrack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_race_track_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_track/edit.html.twig', [
            'race_track' => $raceTrack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_track_delete', methods: ['POST'])]
    public function delete(Request $request, RaceTrack $raceTrack, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceTrack->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceTrack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_race_track_index', [], Response::HTTP_SEE_OTHER);
    }
}
