<?php

namespace App\Controller\Web;

use App\Entity\AppInventory;
use App\Form\InventoryType;
use App\Repository\AppInventoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/inventory', name: 'admin.inventory.', options: ['expose' => true], format: 'html', utf8: true)]
final class AppInventoryController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(AppInventoryRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.inventory.index');

        return $this->render('@App/admin/inventory/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Inventory', 'lvl2' => $title],
            'index'           => 'admin.inventory.index',
            'create'          => 'admin.inventory.create',
            'inventories'     => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $inventory = new AppInventory();
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($inventory);
            $entityManager->flush();

            return $this->redirectToRoute('admin.inventory.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.inventory.create');

        return $this->render('@App/admin/inventory/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Inventory', 'lvl2' => $title],
            'index'           => 'admin.inventory.index',
            'current'         => $request->attributes->get('_route'),
            'inventory'       => $inventory,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, AppInventory $inventory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.inventory.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.inventory.update');

        return $this->render('@App/admin/inventory/form.html.twig', [
            'controller_name' => $title . $inventory->getLabel(),
            'breadcrumb'      => ['lvl1' => 'Inventory', 'lvl2' => $title],
            'index'           => 'admin.inventory.index',
            'current'         => $request->attributes->get('_route'),
            'inventory'       => $inventory,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, AppInventory $inventory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inventory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($inventory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.inventory.index', [], Response::HTTP_SEE_OTHER);
    }
}
