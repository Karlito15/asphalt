<?php

namespace App\Controller\Back\Race;

use App\Persistence\Entity\RaceMode;
use App\Persistence\Form\RaceModeType;
use App\Persistence\Repository\RaceModeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/race/mode',
    name: 'admin.race.mode.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class ModeController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(RaceModeRepository $raceModeRepository): Response
    {
        return $this->render('@App/race_mode/index.html.twig', [
            'race_modes' => $raceModeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceMode = new RaceMode();
        $form = $this->createForm(RaceModeType::class, $raceMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceMode);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_mode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/race_mode/new.html.twig', [
            'race_mode' => $raceMode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(RaceMode $raceMode): Response
    {
        return $this->render('@App/race_mode/show.html.twig', [
            'race_mode' => $raceMode,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, RaceMode $raceMode, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceModeType::class, $raceMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_race_mode_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/race_mode/edit.html.twig', [
            'race_mode' => $raceMode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, RaceMode $raceMode, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceMode->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceMode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_race_mode_index', [], Response::HTTP_SEE_OTHER);
    }
}
