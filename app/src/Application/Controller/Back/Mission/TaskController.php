<?php

declare(strict_types=1);

namespace App\Application\Controller\Back\Mission;

use App\Application\Service\Controller\WebController;
use App\Domain\Entity\MissionTask;
use App\Domain\Form\Back\MissionTaskType;
use App\Domain\Repository\MissionTaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

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
    use WebController;

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'admin.mission.task.index',
      'create' => 'admin.mission.task.create',
      'read'   => null,
      'update' => 'admin.mission.task.update',
      'delete' => 'admin.mission.task.delete',
    ];

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, MissionTaskRepository $repository): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.mission');
        $title = $this->translator->trans('text.all.tasks');

        return $this->render('@App/theme-aero/contents/back/mission/common.html.twig', [
            'container'         => 'container-fluid',
            'breadcrumb'        => self::Breadcrumb($home, $title),
            'links'             => self::$crud,
            'entities'          => $repository->findAll(),
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'theme'             => 'dark',
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.mission');
        $page   = $this->translator->trans('text.task');
        $title  = $this->translator->trans('text.create.task');
        $entity = new MissionTask();
        $form   = $this->createForm(MissionTaskType::class, $entity)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'success',
                message: sprintf($this->translator->trans('notification.created'), $entity->getValue())
            );

            return $this->redirectToIndex();
        }

        return $this->render('@App/theme-aero/contents/back/common-form.html.twig', [
            'container'         => 'container-fluid',
            'breadcrumb'        => self::Breadcrumb($home, $page),
            'links'             => self::$crud,
            'entities'          => $entity,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'form'              => $form,
            'theme'             => 'dark',
        ]);
    }

    #[Route('/update.php/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, MissionTask $entities, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.mission');
        $page  = $this->translator->trans('text.task');
        $title = $entities->getValue();
        $form  = $this->createForm(MissionTaskType::class, $entities)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'info',
                message: sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getValue())
            );

            return $this->redirectToIndex();
        }

        return $this->render('@App/theme-aero/contents/back/common-form.html.twig', [
            'container'         => 'container-fluid',
            'breadcrumb'        => self::Breadcrumb($home, $page),
            'links'             => self::$crud,
            'entities'          => $entities,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'form'              => $form,
            'theme'             => 'dark',
        ]);
    }

    #[Route('/delete.php/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, MissionTask $entities, EntityManagerInterface $manager): Response
    {
        ### Forms
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'error',
                message: sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getValue())
            );
        }

        return $this->redirectToIndex();
    }
}
