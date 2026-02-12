<?php

namespace App\Controller\Back\Race;

use App\Persistence\Entity\RaceRegion;
use App\Persistence\Form\RaceRegionType;
use App\Persistence\Repository\RaceRegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/race/region',
    name: 'admin.race.region.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class RegionController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(RaceRegionRepository $raceRegionRepository): Response
    {
        return $this->render('@App/race_region/index.html.twig', [
            'race_regions' => $raceRegionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceRegion = new RaceRegion();
        $form = $this->createForm(RaceRegionType::class, $raceRegion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceRegion);
            $entityManager->flush();

            return $this->redirectToRoute('app_race_region_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/race_region/new.html.twig', [
            'race_region' => $raceRegion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(RaceRegion $raceRegion): Response
    {
        return $this->render('@App/race_region/show.html.twig', [
            'race_region' => $raceRegion,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, RaceRegion $raceRegion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceRegionType::class, $raceRegion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_race_region_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/race_region/edit.html.twig', [
            'race_region' => $raceRegion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, RaceRegion $raceRegion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceRegion->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceRegion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_race_region_index', [], Response::HTTP_SEE_OTHER);
    }
}
