<?php

namespace App\Controller\Web;

use App\Entity\AppMission;
use App\Form\App\MissionType;
use App\Repository\AppMissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/mission', name: 'app.mission.', options: ['expose' => true], format: 'html', utf8: true)]
final class AppMissionController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(AppMissionRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.app.mission.index');

        return $this->render('@App/app/mission/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Mission', 'lvl2' => $title],
            'index'           => 'app.mission.index',
            'create'          => 'app.mission.create',
            'missions'        => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $appMission = new AppMission();
        $form = $this->createForm(MissionType::class, $appMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appMission);
            $entityManager->flush();

            return $this->redirectToRoute('app.mission.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.app.mission.create');

        return $this->render('@App/app/mission/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Mission', 'lvl2' => $title],
            'index'           => 'app.mission.index',
            'current'         => $request->attributes->get('_route'),
            'mission'         => $appMission,
            'form'            => $form,
        ]);
    }

    #[Route('/read/{id}.php', name: 'read', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function read(Request $request, AppMission $appMission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionType::class, $appMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app.mission.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.app.mission.update');

        return $this->render('@App/app/mission/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Mission', 'lvl2' => $title],
            'current'         => $request->attributes->get('_route'),
            'index'           => 'app.mission.index',
            'mission'         => $appMission,
            'form'            => $form,

        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, AppMission $appMission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionType::class, $appMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app.mission.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.app.mission.update');

        return $this->render('@App/app/mission/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Mission', 'lvl2' => $title],
            'current'         => $request->attributes->get('_route'),
            'index'           => 'app.mission.index',
            'mission'         => $appMission,
            'form'            => $form,

        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, AppMission $appMission, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appMission->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($appMission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app.mission.index', [], Response::HTTP_SEE_OTHER);
    }
}
