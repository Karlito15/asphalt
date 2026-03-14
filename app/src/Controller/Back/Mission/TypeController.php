<?php

declare(strict_types=1);

namespace App\Controller\Back\Mission;

use App\Persistence\Entity\MissionType;
use App\Persistence\Form\Back\MissionTypeType;
use App\Persistence\Repository\MissionTypeRepository;
use App\Toolbox\Trait\Controller\WebController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/mission/type',
    name: 'admin.mission.type.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class TypeController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index    = 'admin.mission.type.index';

    /** @description link to the create page */
    private static string $create   = 'admin.mission.type.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.mission.type.delete';

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, MissionTypeRepository $repository): Response
    {
        // Variables
        $home  = $this->translator->trans('text.mission');
        $title = $this->translator->trans('text.all.types');

        return $this->render('@App/contents/back/mission/common.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => self::LinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        // Variables
        $home  = $this->translator->trans('text.mission');
        $page  = $this->translator->trans('text.type');
        $title = $this->translator->trans('text.create.type');
        $entity = new MissionType();
        $form = $this->createForm(MissionTypeType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $page,
                'message' => sprintf($this->translator->trans('notification.created'), $entity->getSlug())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::Breadcrump($home, $page),
            'links'           => self::LinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entity,
            'form'            => $form,
        ]);
    }

    #[Route('/update.php/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, MissionType $entities, EntityManagerInterface $manager): Response
    {
        // Variables
        $home  = $this->translator->trans('text.mission');
        $page  = $this->translator->trans('text.type');
        $title = $entities->getValue();
        $form  = $this->createForm(MissionTypeType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.type'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getValue())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::Breadcrump($home, $page),
            'links'           => self::LinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, MissionType $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.type'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getValue())
            ]);
        }

        return $this->redirectToIndex();
    }
}
