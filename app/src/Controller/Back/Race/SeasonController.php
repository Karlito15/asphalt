<?php

namespace App\Controller\Back\Race;

use App\Persistence\Entity\RaceSeason;
use App\Persistence\Form\RaceSeasonType;
use App\Persistence\Repository\RaceSeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/race/season',
    name: 'admin.race.season.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class SeasonController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(RaceSeasonRepository $raceSeasonRepository): Response
    {
        return $this->render('@App/race_season/index.html.twig', [
            'race_seasons' => $raceSeasonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceSeason = new RaceSeason();
        $form = $this->createForm(RaceSeasonType::class, $raceSeason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceSeason);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_season_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/race_season/new.html.twig', [
            'race_season' => $raceSeason,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(RaceSeason $raceSeason): Response
    {
        return $this->render('@App/race_season/show.html.twig', [
            'race_season' => $raceSeason,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, RaceSeason $raceSeason, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceSeasonType::class, $raceSeason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_race_season_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/race_season/edit.html.twig', [
            'race_season' => $raceSeason,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, RaceSeason $raceSeason, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceSeason->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceSeason);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_race_season_index', [], Response::HTTP_SEE_OTHER);
    }
}
