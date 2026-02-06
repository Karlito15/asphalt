<?php

namespace App\Infrastructure\Controller\Back\Setting;

use App\Infrastructure\Persistence\Entity\SettingTag;
use App\Infrastructure\Persistence\Form\SettingTagType;
use App\Infrastructure\Persistence\Repository\SettingTagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/setting/tag')]
final class TagController extends AbstractController
{
    #[Route(name: 'app_setting_tag_index', methods: ['GET'])]
    public function index(SettingTagRepository $settingTagRepository): Response
    {
        return $this->render('@App/setting_tag/index.html.twig', [
            'setting_tags' => $settingTagRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_setting_tag_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $settingTag = new SettingTag();
        $form = $this->createForm(SettingTagType::class, $settingTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($settingTag);
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_tag/new.html.twig', [
            'setting_tag' => $settingTag,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_setting_tag_show', methods: ['GET'])]
    public function show(SettingTag $settingTag): Response
    {
        return $this->render('@App/setting_tag/show.html.twig', [
            'setting_tag' => $settingTag,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_setting_tag_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SettingTag $settingTag, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SettingTagType::class, $settingTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_tag/edit.html.twig', [
            'setting_tag' => $settingTag,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_setting_tag_delete', methods: ['POST'])]
    public function delete(Request $request, SettingTag $settingTag, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingTag->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingTag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_setting_tag_index', [], Response::HTTP_SEE_OTHER);
    }
}
