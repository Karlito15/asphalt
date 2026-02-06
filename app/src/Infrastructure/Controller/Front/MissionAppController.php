<?php

namespace App\Infrastructure\Controller\Front;

use App\Infrastructure\Persistence\Entity\MissionApp;
use App\Infrastructure\Persistence\Form\MissionAppType;
use App\Infrastructure\Persistence\Repository\MissionAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mission/app')]
final class MissionAppController extends AbstractController
{
    #[Route(name: 'app_mission_app_index', methods: ['GET'])]
    public function index(MissionAppRepository $missionAppRepository): Response
    {
        return $this->render('mission_app/index.html.twig', [
            'mission_apps' => $missionAppRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mission_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $missionApp = new MissionApp();
        $form = $this->createForm(MissionAppType::class, $missionApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($missionApp);
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission_app/new.html.twig', [
            'mission_app' => $missionApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mission_app_show', methods: ['GET'])]
    public function show(MissionApp $missionApp): Response
    {
        return $this->render('mission_app/show.html.twig', [
            'mission_app' => $missionApp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mission_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MissionApp $missionApp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionAppType::class, $missionApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission_app/edit.html.twig', [
            'mission_app' => $missionApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mission_app_delete', methods: ['POST'])]
    public function delete(Request $request, MissionApp $missionApp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionApp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($missionApp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mission_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
