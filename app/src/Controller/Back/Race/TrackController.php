<?php

namespace App\Controller\Back\Race;

use App\Persistence\Entity\RaceTrack;
use App\Persistence\Form\RaceTrackType;
use App\Persistence\Repository\RaceTrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/race/track',
    name: 'admin.race.track.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class TrackController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(RaceTrackRepository $raceTrackRepository): Response
    {
        return $this->render('@App/race_track/index.html.twig', [
            'race_tracks' => $raceTrackRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceTrack = new RaceTrack();
        $form = $this->createForm(RaceTrackType::class, $raceTrack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceTrack);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_track_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/race_track/new.html.twig', [
            'race_track' => $raceTrack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(RaceTrack $raceTrack): Response
    {
        return $this->render('@App/race_track/show.html.twig', [
            'race_track' => $raceTrack,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, RaceTrack $raceTrack, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceTrackType::class, $raceTrack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_race_track_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/race_track/edit.html.twig', [
            'race_track' => $raceTrack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, RaceTrack $raceTrack, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceTrack->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceTrack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_race_track_index', [], Response::HTTP_SEE_OTHER);
    }
}
