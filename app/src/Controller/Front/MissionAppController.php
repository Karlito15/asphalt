<?php

namespace App\Controller\Front;

use App\Persistence\Entity\MissionApp;
use App\Persistence\Form\MissionAppType;
use App\Persistence\Repository\MissionAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/mission',
    name: 'app.mission.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class MissionAppController extends AbstractController
{
    #[Route(name: 'index', methods: ['GET'])]
    public function index(MissionAppRepository $missionAppRepository): Response
    {
        return $this->render('mission_app/index.html.twig', [
            'mission_apps' => $missionAppRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $missionApp = new MissionApp();
        $form = $this->createForm(MissionAppType::class, $missionApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($missionApp);
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission_app/new.html.twig', [
            'mission_app' => $missionApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(MissionApp $missionApp): Response
    {
        return $this->render('mission_app/show.html.twig', [
            'mission_app' => $missionApp,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, MissionApp $missionApp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionAppType::class, $missionApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission_app/edit.html.twig', [
            'mission_app' => $missionApp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, MissionApp $missionApp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionApp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($missionApp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mission_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
