<?php

declare(strict_types=1);

namespace App\Application\Controller\Back\Race;

use App\Application\Service\Controller\WebController;
use App\Domain\Entity\RaceTrack;
use App\Domain\Form\Back\RaceTrackType;
use App\Domain\Repository\RaceTrackRepository;
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

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'admin.race.track.index',
      'create' => 'admin.race.track.create',
      'read'   => null,
      'update' => 'admin.race.track.update',
      'delete' => 'admin.race.track.delete',
    ];

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, RaceTrackRepository $repository): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.race');
        $title = $this->translator->trans('text.all.tracks');

        return $this->render('@App/theme-aero/contents/back/race/track.html.twig', [
            'container'         => 'container-fluid',
            'breadcrumb'        => self::Breadcrumb($home, $title),
            'links'             => self::$crud,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->findAll(),
            'theme'             => 'dark',
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.race');
        $page   = $this->translator->trans('text.track');
        $title  = $this->translator->trans('text.create.track');
        $entity = new RaceTrack();
        $form   = $this->createForm(RaceTrackType::class, $entity)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'success',
                message: sprintf($this->translator->trans('notification.created'), $entity->getNameEnglish())
            );

            return $this->redirectToIndex();
        }

        return $this->render('@App/theme-aero/contents/back/common-form.html.twig', [
            'container'         => 'container-fluid',
            'breadcrumb'        => self::Breadcrumb($home, $page),
            'links'             => self::$crud,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $entity,
            'form'              => $form,
            'theme'             => 'dark',
        ]);
    }

    #[Route('/update.php/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceTrack $entities, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.race');
        $page  = $this->translator->trans('text.track');
        $title = $entities->getNameEnglish();
        $form  = $this->createForm(RaceTrackType::class, $entities)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'info',
                message: sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getNameEnglish())
            );

            return $this->redirectToIndex();
        }

        return $this->render('@App/theme-aero/contents/back/common-form.html.twig', [
            'container'         => 'container-fluid',
            'breadcrumb'        => self::Breadcrumb($home, $page),
            'links'             => self::$crud,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $entities,
            'form'              => $form,
            'theme'             => 'dark',
        ]);
    }

    #[Route('/delete.php/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, RaceTrack $entities, EntityManagerInterface $manager): Response
    {
        ### Forms
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'error',
                message: sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getNameEnglish())
            );
        }

        return $this->redirectToIndex();
    }
}
