<?php

namespace App\Controller\Back\Setting;

use App\Persistence\Entity\SettingClass;
use App\Persistence\Form\SettingClassType;
use App\Persistence\Repository\SettingClassRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/setting/class',
    name: 'admin.setting.class.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class ClassController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(SettingClassRepository $settingClassRepository): Response
    {
        return $this->render('@App/setting_class/index.html.twig', [
            'setting_classes' => $settingClassRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $settingClass = new SettingClass();
        $form = $this->createForm(SettingClassType::class, $settingClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($settingClass);
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_class_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_class/new.html.twig', [
            'setting_class' => $settingClass,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(SettingClass $settingClass): Response
    {
        return $this->render('@App/setting_class/show.html.twig', [
            'setting_class' => $settingClass,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, SettingClass $settingClass, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SettingClassType::class, $settingClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_class_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_class/edit.html.twig', [
            'setting_class' => $settingClass,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SettingClass $settingClass, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingClass->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingClass);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_setting_class_index', [], Response::HTTP_SEE_OTHER);
    }
}
