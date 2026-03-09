<?php

declare(strict_types=1);

namespace App\Controller\Back\Race;

use App\Persistence\Entity\RaceTrack;
use App\Persistence\Form\Back\RaceTrackType;
use App\Persistence\Repository\RaceTrackRepository;
use App\Toolbox\Trait\Controller\WebController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/race/track',
    name: 'admin.race.track.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class TrackController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index    = 'admin.race.track.index';

    /** @description link to the create page */
    private static string $create   = 'admin.race.track.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.race.track.delete';

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, RaceTrackRepository $repository): Response
    {
        // Variables
        $home  = $this->translator->trans('text.race');
        $title = $this->translator->trans('text.all.tracks');

        return $this->render('@App/contents/back/race/track.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::getBreadcrump($home, $title),
            'links'           => self::getLinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        // Variables
        $home  = $this->translator->trans('text.race');
        $page  = $this->translator->trans('text.track');
        $title = $this->translator->trans('text.create.track');
        $entity = new RaceTrack();
        $form = $this->createForm(RaceTrackType::class, $entity)->handleRequest($request);

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
            'breadcrumb'      => self::getBreadcrump($home, $page),
            'links'           => self::getLinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entity,
            'form'            => $form,
        ]);
    }

    #[Route('/update.php/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceTrack $entities, EntityManagerInterface $manager): Response
    {
        // Variables
        $home  = $this->translator->trans('text.race');
        $page  = $this->translator->trans('text.track');
        $title = $entities->getNameEnglish();
        $form  = $this->createForm(RaceTrackType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.track'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getNameEnglish())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::getBreadcrump($home, $page),
            'links'           => self::getLinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, RaceTrack $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.track'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getNameEnglish())
            ]);
        }

        return $this->redirectToIndex();
    }
}
