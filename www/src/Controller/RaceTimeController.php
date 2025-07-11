<?php

namespace App\Controller;

use App\Entity\RaceTime;
use App\Form\RaceTimeType;
use App\Repository\RaceTimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/race/time')]
final class RaceTimeController extends AbstractController
{
    #[Route(name: 'app_race_time_index', methods: ['GET'])]
    public function index(RaceTimeRepository $raceTimeRepository): Response
    {
        return $this->render('race_time/index.html.twig', [
            'race_times' => $raceTimeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_race_time_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceTime = new RaceTime();
        $form = $this->createForm(RaceTimeType::class, $raceTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceTime);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_time_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_time/new.html.twig', [
            'race_time' => $raceTime,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_time_show', methods: ['GET'])]
    public function show(RaceTime $raceTime): Response
    {
        return $this->render('race_time/show.html.twig', [
            'race_time' => $raceTime,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_race_time_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceTime $raceTime, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceTimeType::class, $raceTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_race_time_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_time/edit.html.twig', [
            'race_time' => $raceTime,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_time_delete', methods: ['POST'])]
    public function delete(Request $request, RaceTime $raceTime, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceTime->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceTime);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_race_time_index', [], Response::HTTP_SEE_OTHER);
    }
}
