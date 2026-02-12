<?php

namespace App\Controller\Back\Mission;

use App\Persistence\Entity\MissionType;
use App\Persistence\Form\MissionTypeType;
use App\Persistence\Repository\MissionTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/mission/type',
    name: 'admin.mission.type.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class TypeController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(MissionTypeRepository $missionTypeRepository): Response
    {
        return $this->render('mission_type/index.html.twig', [
            'mission_types' => $missionTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $missionType = new MissionType();
        $form = $this->createForm(MissionTypeType::class, $missionType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($missionType);
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission_type/new.html.twig', [
            'mission_type' => $missionType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(MissionType $missionType): Response
    {
        return $this->render('mission_type/show.html.twig', [
            'mission_type' => $missionType,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, MissionType $missionType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionTypeType::class, $missionType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission_type/edit.html.twig', [
            'mission_type' => $missionType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, MissionType $missionType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionType->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($missionType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mission_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
