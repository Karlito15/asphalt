<?php

namespace App\Controller;

use App\Entity\RaceRegion;
use App\Form\RaceRegionType;
use App\Repository\RaceRegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/race/region')]
final class RaceRegionController extends AbstractController
{
    #[Route(name: 'app_race_region_index', methods: ['GET'])]
    public function index(RaceRegionRepository $raceRegionRepository): Response
    {
        return $this->render('race_region/index.html.twig', [
            'race_regions' => $raceRegionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_race_region_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceRegion = new RaceRegion();
        $form = $this->createForm(RaceRegionType::class, $raceRegion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceRegion);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_region_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_region/new.html.twig', [
            'race_region' => $raceRegion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_region_show', methods: ['GET'])]
    public function show(RaceRegion $raceRegion): Response
    {
        return $this->render('race_region/show.html.twig', [
            'race_region' => $raceRegion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_race_region_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RaceRegion $raceRegion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceRegionType::class, $raceRegion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_race_region_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('race_region/edit.html.twig', [
            'race_region' => $raceRegion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_race_region_delete', methods: ['POST'])]
    public function delete(Request $request, RaceRegion $raceRegion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceRegion->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceRegion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_race_region_index', [], Response::HTTP_SEE_OTHER);
    }
}
