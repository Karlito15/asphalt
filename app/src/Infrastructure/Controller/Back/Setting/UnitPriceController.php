<?php

namespace App\Infrastructure\Controller\Back\Setting;

use App\Infrastructure\Persistence\Entity\SettingUnitPrice;
use App\Infrastructure\Persistence\Form\SettingUnitPriceType;
use App\Infrastructure\Persistence\Repository\SettingUnitPriceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/setting/unit/price')]
final class UnitPriceController extends AbstractController
{
    #[Route(name: 'app_setting_unit_price_index', methods: ['GET'])]
    public function index(SettingUnitPriceRepository $settingUnitPriceRepository): Response
    {
        return $this->render('@App/setting_unit_price/index.html.twig', [
            'setting_unit_prices' => $settingUnitPriceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_setting_unit_price_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'app_setting_unit_price_show', methods: ['GET'])]
    public function show(SettingUnitPrice $settingUnitPrice): Response
    {
        return $this->render('@App/setting_unit_price/show.html.twig', [
            'setting_unit_price' => $settingUnitPrice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_setting_unit_price_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SettingUnitPrice $settingUnitPrice, EntityManagerInterface $entityManager): Response
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

    #[Route('/{id}', name: 'app_setting_unit_price_delete', methods: ['POST'])]
    public function delete(Request $request, SettingUnitPrice $settingUnitPrice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingUnitPrice->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingUnitPrice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_setting_unit_price_index', [], Response::HTTP_SEE_OTHER);
    }
}
