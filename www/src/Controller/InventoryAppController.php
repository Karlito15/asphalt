<?php

namespace App\Controller;

use App\Entity\InventoryApp;
use App\Form\InventoryAppType;
use App\Repository\InventoryAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/inventory/app')]
final class InventoryAppController extends AbstractController
{
    #[Route(name: 'app_inventory_app_index', methods: ['GET'])]
    public function index(InventoryAppRepository $inventoryAppRepository): Response
    {
        return $this->render('inventory_app/index.html.twig', [
            'inventory_apps' => $inventoryAppRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_inventory_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $inventoryApp = new InventoryApp();
        $form = $this->createForm(InventoryAppType::class, $inventoryApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($inventoryApp);
            $entityManager->flush();

            return $this->redirectToRoute('app_inventory_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('inventory_app/new.html.twig', [
            'inventory_app' => $inventoryApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inventory_app_show', methods: ['GET'])]
    public function show(InventoryApp $inventoryApp): Response
    {
        return $this->render('inventory_app/show.html.twig', [
            'inventory_app' => $inventoryApp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_inventory_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InventoryApp $inventoryApp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InventoryAppType::class, $inventoryApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_inventory_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('inventory_app/edit.html.twig', [
            'inventory_app' => $inventoryApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inventory_app_delete', methods: ['POST'])]
    public function delete(Request $request, InventoryApp $inventoryApp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inventoryApp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($inventoryApp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_inventory_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
