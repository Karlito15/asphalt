<?php

declare(strict_types=1);

namespace App\Controller\Back\Mission;

use App\Persistence\Entity\MissionApp;
use App\Persistence\Form\Back\MissionAppType;
use App\Persistence\Repository\MissionAppRepository;
use App\Toolbox\Trait\Controller\WebController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/mission/app',
    name: 'admin.mission.app.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class AppController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index    = 'admin.mission.app.index';

    /** @description link to the create page */
    private static string $create   = 'admin.mission.app.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.mission.app.delete';

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, MissionAppRepository $repository): Response
    {
        // Variables
        $home  = $this->translator->trans('text.mission');
        $title = $this->translator->trans('text.all.missions');

        return $this->render('@App/contents/back/mission/app.html.twig', [
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
        $title = $this->translator->trans('text.create.mission');
        $entity = new MissionApp();
        $form = $this->createForm(MissionAppType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $title,
                'message' => sprintf($this->translator->trans('notification.created'), $entity->getId())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => self::LinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entity,
            'form'            => $form,
        ]);
    }

    #[Route('/update.php/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, MissionApp $entities, EntityManagerInterface $manager): Response
    {
        // Variables
        $home  = $this->translator->trans('text.mission');
        $title = $entities->getDescription();
        $form  = $this->createForm(MissionAppType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $title,
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getDescription())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => self::LinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, MissionApp $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.mission'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getDescription())
            ]);
        }

        return $this->redirectToIndex();
    }
}
