<?php

namespace App\Controller\Back\Race;

use App\Persistence\Entity\RaceTime;
use App\Persistence\Form\RaceTimeType;
use App\Persistence\Repository\RaceTimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/race/time',
    name: 'admin.race.time.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class TimeController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(RaceTimeRepository $raceTimeRepository): Response
    {
        return $this->render('@App/race_time/index.html.twig', [
            'race_times' => $raceTimeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceTime = new RaceTime();
        $form = $this->createForm(RaceTimeType::class, $raceTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceTime);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_time_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/race_time/new.html.twig', [
            'race_time' => $raceTime,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(RaceTime $raceTime): Response
    {
        return $this->render('@App/race_time/show.html.twig', [
            'race_time' => $raceTime,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, RaceTime $raceTime, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceTimeType::class, $raceTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_race_time_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/race_time/edit.html.twig', [
            'race_time' => $raceTime,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, RaceTime $raceTime, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceTime->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceTime);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_race_time_index', [], Response::HTTP_SEE_OTHER);
    }
}
