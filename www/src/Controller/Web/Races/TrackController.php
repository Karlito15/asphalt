<?php

namespace App\Controller\Web\Races;

use App\Entity\RaceTrack;
use App\Form\Races\TrackType;
use App\Repository\RaceTrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/races/track', name: 'admin.race.track.', options: ['expose' => true], format: 'html', utf8: true)]
final class TrackController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(RaceTrackRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.track.index');

        return $this->render('@App/admin/races/track/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.track.index',
            'create'          => 'admin.race.track.create',
            'tracks'          => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceTrack = new RaceTrack();
        $form = $this->createForm(TrackType::class, $raceTrack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceTrack);
            $entityManager->flush();

            return $this->redirectToRoute('admin.race.track.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.track.create');

        return $this->render('@App/admin/races/track/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.track.index',
            'current'         => $request->attributes->get('_route'),
            'race_track'      => $raceTrack,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceTrack $raceTrack, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrackType::class, $raceTrack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.race.track.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.track.update');

        return $this->render('@App/admin/races/track/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.track.index',
            'current'         => $request->attributes->get('_route'),
            'race_track'      => $raceTrack,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, RaceTrack $raceTrack, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceTrack->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceTrack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.race.track.index', [], Response::HTTP_SEE_OTHER);
    }
}
