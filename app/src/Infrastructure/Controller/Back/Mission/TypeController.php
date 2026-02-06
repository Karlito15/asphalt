<?php

namespace App\Infrastructure\Controller\Back\Mission;

use App\Infrastructure\Persistence\Entity\MissionType;
use App\Infrastructure\Persistence\Form\MissionTypeType;
use App\Infrastructure\Persistence\Repository\MissionTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mission/type')]
final class TypeController extends AbstractController
{
    #[Route(name: 'app_mission_type_index', methods: ['GET'])]
    public function index(MissionTypeRepository $missionTypeRepository): Response
    {
        return $this->render('mission_type/index.html.twig', [
            'mission_types' => $missionTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mission_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'app_mission_type_show', methods: ['GET'])]
    public function show(MissionType $missionType): Response
    {
        return $this->render('mission_type/show.html.twig', [
            'mission_type' => $missionType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mission_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MissionType $missionType, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'app_mission_type_delete', methods: ['POST'])]
    public function delete(Request $request, MissionType $missionType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionType->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($missionType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mission_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
