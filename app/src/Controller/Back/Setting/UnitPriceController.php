<?php

namespace App\Controller\Back\Setting;

use App\Persistence\Entity\SettingUnitPrice;
use App\Persistence\Form\SettingUnitPriceType;
use App\Persistence\Repository\SettingUnitPriceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/setting/unit-price',
    name: 'admin.setting.unit-price.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class UnitPriceController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(SettingUnitPriceRepository $settingUnitPriceRepository): Response
    {
        return $this->render('@App/setting_unit_price/index.html.twig', [
            'setting_unit_prices' => $settingUnitPriceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $settingUnitPrice = new SettingUnitPrice();
        $form = $this->createForm(SettingUnitPriceType::class, $settingUnitPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($settingUnitPrice);
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_unit_price_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_unit_price/new.html.twig', [
            'setting_unit_price' => $settingUnitPrice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(SettingUnitPrice $settingUnitPrice): Response
    {
        return $this->render('@App/setting_unit_price/show.html.twig', [
            'setting_unit_price' => $settingUnitPrice,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, SettingUnitPrice $settingUnitPrice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SettingUnitPriceType::class, $settingUnitPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_unit_price_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/setting_unit_price/edit.html.twig', [
            'setting_unit_price' => $settingUnitPrice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SettingUnitPrice $settingUnitPrice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingUnitPrice->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingUnitPrice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_setting_unit_price_index', [], Response::HTTP_SEE_OTHER);
    }
}
