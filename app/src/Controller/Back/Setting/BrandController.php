<?php

namespace App\Controller\Back\Setting;

use App\Persistence\Entity\SettingBrand;
use App\Persistence\Form\SettingBrandType;
use App\Persistence\Repository\SettingBrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/setting/brand',
    name: 'admin.setting.brand.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class BrandController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(SettingBrandRepository $settingBrandRepository): Response
    {
        return $this->render('@App/setting_brand/index.html.twig', [
            'setting_brands' => $settingBrandRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(SettingBrand $settingBrand): Response
    {
        return $this->render('@App/setting_brand/show.html.twig', [
            'setting_brand' => $settingBrand,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, SettingBrand $settingBrand, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SettingBrand $settingBrand, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingBrand->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingBrand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_setting_brand_index', [], Response::HTTP_SEE_OTHER);
    }
}
