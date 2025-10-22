<?php

namespace App\Controller\Back;

use App\Entity\InventoryApp;
use App\Form\Back\InventoryAppType;
use App\Repository\InventoryAppRepository;
use App\Service\Cache\MissionAppService;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/inventory', name: 'admin.inventory.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class InventoryController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index    = 'admin.inventory.index';

    /** @description link to the create page */
    private static string $create   = 'admin.inventory.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.inventory.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly MissionAppService $service,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, InventoryAppRepository $repository): Response
    {
        $title = $this->translator->trans('text.all.inventories');

        return $this->render('@App/back/contents/inventory/index.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.back-office'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'entities'        => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $title    = $this->translator->trans('text.create.inventory');
        $entities = new InventoryApp();
        $form     = $this->createForm(InventoryAppType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $this->translator->trans('text.inventory'),
                'message' => sprintf($this->translator->trans('notification.created'), $entities->getId(), $entities->getValue())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.inventory'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, InventoryApp $entities, EntityManagerInterface $manager): Response
    {
        $title = $entities->getLabel();
        $form = $this->createForm(InventoryAppType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.inventory'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getValue())
            ]);

            $this->service->cacheDelete();

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.inventory'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, InventoryApp $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.inventory'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getValue())
            ]);

            $this->service->cacheDelete();
        }

        return $this->redirectToIndex();
    }
}
