<?php

namespace App\Controller\Back\Setting;

use App\Persistence\Entity\SettingTag;
use App\Persistence\Form\SettingTagType;
use App\Persistence\Repository\SettingTagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/setting/tag',
    name: 'admin.setting.tag.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class TagController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(SettingTagRepository $settingTagRepository): Response
    {
        return $this->render('@App/setting_tag/index.html.twig', [
            'setting_tags' => $settingTagRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(SettingTag $settingTag): Response
    {
        return $this->render('@App/setting_tag/show.html.twig', [
            'setting_tag' => $settingTag,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, SettingTag $settingTag, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SettingTag $settingTag, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingTag->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingTag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_setting_tag_index', [], Response::HTTP_SEE_OTHER);
    }
}
