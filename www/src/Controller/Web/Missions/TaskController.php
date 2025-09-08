<?php

namespace App\Controller\Web\Missions;

use App\Entity\MissionTask;
use App\Form\Missions\TaskType;
use App\Repository\MissionTaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/missions/task', name: 'admin.mission.task.', options: ['expose' => true], format: 'html', utf8: true)]
final class TaskController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(MissionTaskRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.task.index');

        return $this->render('@App/admin/missions/task/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Mission', 'lvl2' => $title],
            'index'           => 'admin.mission.type.index',
            'create'          => 'admin.mission.task.create',
            'tasks'           => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $missionTask = new MissionTask();
        $form = $this->createForm(TaskType::class, $missionTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($missionTask);
            $entityManager->flush();

            return $this->redirectToRoute('admin.mission.task.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.task.create');

        return $this->render('@App/admin/missions/task/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Mission', 'lvl2' => $title],
            'index'           => 'admin.mission.task.index',
            'current'         => $request->attributes->get('_route'),
            'mission_task'    => $missionTask,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, MissionTask $missionTask, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskType::class, $missionTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.mission.task.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.task.update');

        return $this->render('@App/admin/missions/task/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Mission', 'lvl2' => $title],
            'index'           => 'admin.mission.task.index',
            'current'         => $request->attributes->get('_route'),
            'mission_task'    => $missionTask,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, MissionTask $missionTask, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionTask->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($missionTask);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.mission.task.index', [], Response::HTTP_SEE_OTHER);
    }
}
