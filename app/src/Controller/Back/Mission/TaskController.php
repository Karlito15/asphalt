<?php

namespace App\Controller\Back\Mission;

use App\Persistence\Entity\MissionTask;
use App\Persistence\Form\MissionTaskType;
use App\Persistence\Repository\MissionTaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/mission/task',
    name: 'admin.mission.task.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class TaskController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(MissionTaskRepository $missionTaskRepository): Response
    {
        return $this->render('mission_task/index.html.twig', [
            'mission_tasks' => $missionTaskRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(MissionTask $missionTask): Response
    {
        return $this->render('mission_task/show.html.twig', [
            'mission_task' => $missionTask,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, MissionTask $missionTask, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, MissionTask $missionTask, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionTask->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($missionTask);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mission_task_index', [], Response::HTTP_SEE_OTHER);
    }
}
