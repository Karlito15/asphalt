<?php

namespace App\Controller\Back\Setting;

use App\Persistence\Entity\SettingBlueprint;
use App\Persistence\Form\SettingBlueprintType;
use App\Persistence\Repository\SettingBlueprintRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/setting/blueprint',
    name: 'admin.setting.blueprint.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class BlueprintController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(SettingBlueprintRepository $settingBlueprintRepository): Response
    {
        return $this->render('@App/setting_blueprint/index.html.twig', [
            'setting_blueprints' => $settingBlueprintRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $settingBlueprint = new SettingBlueprint();
        $form = $this->createForm(SettingBlueprintType::class, $settingBlueprint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($settingBlueprint);
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_blueprint_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_blueprint/new.html.twig', [
            'setting_blueprint' => $settingBlueprint,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(SettingBlueprint $settingBlueprint): Response
    {
        return $this->render('@App/setting_blueprint/show.html.twig', [
            'setting_blueprint' => $settingBlueprint,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, SettingBlueprint $settingBlueprint, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SettingBlueprintType::class, $settingBlueprint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_blueprint_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_blueprint/edit.html.twig', [
            'setting_blueprint' => $settingBlueprint,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SettingBlueprint $settingBlueprint, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingBlueprint->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingBlueprint);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_setting_blueprint_index', [], Response::HTTP_SEE_OTHER);
    }
}
