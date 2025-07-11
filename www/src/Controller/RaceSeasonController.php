<?php

namespace App\Controller;

use App\Entity\RaceSeason;
use App\Form\RaceSeasonType;
use App\Repository\RaceSeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/race/season')]
final class RaceSeasonController extends AbstractController
{
    #[Route(name: 'app_race_season_index', methods: ['GET'])]
    public function index(RaceSeasonRepository $raceSeasonRepository): Response
    {
        return $this->render('race_season/index.html.twig', [
            'race_seasons' => $raceSeasonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_race_season_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceSeason = new RaceSeason();
        $form = $this->createForm(RaceSeasonType::class, $raceSeason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceSeason);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_season_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_season/new.html.twig', [
            'race_season' => $raceSeason,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_season_show', methods: ['GET'])]
    public function show(RaceSeason $raceSeason): Response
    {
        return $this->render('race_season/show.html.twig', [
            'race_season' => $raceSeason,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_race_season_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceSeason $raceSeason, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceSeasonType::class, $raceSeason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_race_season_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_season/edit.html.twig', [
            'race_season' => $raceSeason,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_season_delete', methods: ['POST'])]
    public function delete(Request $request, RaceSeason $raceSeason, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceSeason->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceSeason);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_race_season_index', [], Response::HTTP_SEE_OTHER);
    }
}
