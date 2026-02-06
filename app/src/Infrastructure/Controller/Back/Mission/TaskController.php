<?php

namespace App\Infrastructure\Controller\Back\Mission;

use App\Infrastructure\Persistence\Entity\MissionTask;
use App\Infrastructure\Persistence\Form\MissionTaskType;
use App\Infrastructure\Persistence\Repository\MissionTaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mission/task')]
final class TaskController extends AbstractController
{
    #[Route(name: 'app_mission_task_index', methods: ['GET'])]
    public function index(MissionTaskRepository $missionTaskRepository): Response
    {
        return $this->render('mission_task/index.html.twig', [
            'mission_tasks' => $missionTaskRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mission_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $missionTask = new MissionTask();
        $form = $this->createForm(MissionTaskType::class, $missionTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($missionTask);
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission_task/new.html.twig', [
            'mission_task' => $missionTask,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mission_task_show', methods: ['GET'])]
    public function show(MissionTask $missionTask): Response
    {
        return $this->render('mission_task/show.html.twig', [
            'mission_task' => $missionTask,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mission_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MissionTask $missionTask, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionTaskType::class, $missionTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission_task/edit.html.twig', [
            'mission_task' => $missionTask,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mission_task_delete', methods: ['POST'])]
    public function delete(Request $request, MissionTask $missionTask, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionTask->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($missionTask);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mission_task_index', [], Response::HTTP_SEE_OTHER);
    }
}
