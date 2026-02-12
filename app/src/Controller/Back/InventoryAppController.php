<?php

namespace App\Controller\Back;

use App\Persistence\Entity\InventoryApp;
use App\Persistence\Form\InventoryAppType;
use App\Persistence\Repository\InventoryAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/inventory',
    name: 'admin.inventory.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class InventoryAppController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(InventoryAppRepository $inventoryAppRepository): Response
    {
        return $this->render('@App/back/inventory/index.html.twig', [
            'inventory_apps' => $inventoryAppRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $inventoryApp = new InventoryApp();
        $form = $this->createForm(InventoryAppType::class, $inventoryApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($inventoryApp);
            $entityManager->flush();

            return $this->redirectToRoute('admin.inventory.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/back/inventory/new.html.twig', [
            'inventory_app' => $inventoryApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(InventoryApp $inventoryApp): Response
    {
        return $this->render('@App/back/inventory/show.html.twig', [
            'inventory_app' => $inventoryApp,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, InventoryApp $inventoryApp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InventoryAppType::class, $inventoryApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.inventory.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/back/inventory/edit.html.twig', [
            'inventory_app' => $inventoryApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, InventoryApp $inventoryApp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inventoryApp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($inventoryApp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.inventory.index', [], Response::HTTP_SEE_OTHER);
    }
}
