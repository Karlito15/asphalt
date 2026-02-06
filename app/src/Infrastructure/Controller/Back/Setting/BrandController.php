<?php

namespace App\Infrastructure\Controller\Back\Setting;

use App\Infrastructure\Persistence\Entity\SettingBrand;
use App\Infrastructure\Persistence\Form\SettingBrandType;
use App\Infrastructure\Persistence\Repository\SettingBrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/setting/brand')]
final class BrandController extends AbstractController
{
    #[Route(name: 'app_setting_brand_index', methods: ['GET'])]
    public function index(SettingBrandRepository $settingBrandRepository): Response
    {
        return $this->render('@App/setting_brand/index.html.twig', [
            'setting_brands' => $settingBrandRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_setting_brand_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $settingBrand = new SettingBrand();
        $form = $this->createForm(SettingBrandType::class, $settingBrand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($settingBrand);
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_brand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_brand/new.html.twig', [
            'setting_brand' => $settingBrand,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_setting_brand_show', methods: ['GET'])]
    public function show(SettingBrand $settingBrand): Response
    {
        return $this->render('@App/setting_brand/show.html.twig', [
            'setting_brand' => $settingBrand,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_setting_brand_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SettingBrand $settingBrand, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SettingBrandType::class, $settingBrand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_brand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_brand/edit.html.twig', [
            'setting_brand' => $settingBrand,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_setting_brand_delete', methods: ['POST'])]
    public function delete(Request $request, SettingBrand $settingBrand, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingBrand->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingBrand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_setting_brand_index', [], Response::HTTP_SEE_OTHER);
    }
}
