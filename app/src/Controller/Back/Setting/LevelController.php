<?php

namespace App\Controller\Back\Setting;

use App\Persistence\Entity\SettingLevel;
use App\Persistence\Form\SettingLevelType;
use App\Persistence\Repository\SettingLevelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/setting/level',
    name: 'admin.setting.level.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class LevelController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(SettingLevelRepository $settingLevelRepository): Response
    {
        return $this->render('@App/setting_level/index.html.twig', [
            'setting_levels' => $settingLevelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(SettingLevel $settingLevel): Response
    {
        return $this->render('@App/setting_level/show.html.twig', [
            'setting_level' => $settingLevel,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, SettingLevel $settingLevel, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SettingLevel $settingLevel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingLevel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingLevel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_setting_level_index', [], Response::HTTP_SEE_OTHER);
    }
}
