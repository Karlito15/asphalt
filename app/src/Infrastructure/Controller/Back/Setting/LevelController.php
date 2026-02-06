<?php

namespace App\Infrastructure\Controller\Back\Setting;

use App\Infrastructure\Persistence\Entity\SettingLevel;
use App\Infrastructure\Persistence\Form\SettingLevelType;
use App\Infrastructure\Persistence\Repository\SettingLevelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/setting/level')]
final class LevelController extends AbstractController
{
    #[Route(name: 'app_setting_level_index', methods: ['GET'])]
    public function index(SettingLevelRepository $settingLevelRepository): Response
    {
        return $this->render('@App/setting_level/index.html.twig', [
            'setting_levels' => $settingLevelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_setting_level_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $settingLevel = new SettingLevel();
        $form = $this->createForm(SettingLevelType::class, $settingLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($settingLevel);
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_level/new.html.twig', [
            'setting_level' => $settingLevel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_setting_level_show', methods: ['GET'])]
    public function show(SettingLevel $settingLevel): Response
    {
        return $this->render('@App/setting_level/show.html.twig', [
            'setting_level' => $settingLevel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_setting_level_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SettingLevel $settingLevel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SettingLevelType::class, $settingLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_level/edit.html.twig', [
            'setting_level' => $settingLevel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_setting_level_delete', methods: ['POST'])]
    public function delete(Request $request, SettingLevel $settingLevel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingLevel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingLevel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_setting_level_index', [], Response::HTTP_SEE_OTHER);
    }
}
