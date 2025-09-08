<?php

namespace App\Controller\Web\Races;

use App\Entity\RaceMode;
use App\Form\Races\ModeType;
use App\Repository\RaceModeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/races/mode', name: 'admin.race.mode.', options: ['expose' => true], format: 'html', utf8: true)]
final class ModeController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(RaceModeRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.mode.index');

        return $this->render('@App/admin/races/mode/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.mode.index',
            'create'          => 'admin.race.mode.create',
            'modes'           => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceMode = new RaceMode();
        $form = $this->createForm(ModeType::class, $raceMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceMode);
            $entityManager->flush();

            return $this->redirectToRoute('admin.race.mode.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.mode.create');

        return $this->render('@App/admin/races/mode/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.mode.index',
            'current'         => $request->attributes->get('_route'),
            'race_mode'       => $raceMode,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceMode $raceMode, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModeType::class, $raceMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.race.mode.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.mode.update');

        return $this->render('@App/admin/races/mode/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'current'         => $request->attributes->get('_route'),
            'index'           => 'admin.race.mode.index',
            'race_mode'       => $raceMode,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, RaceMode $raceMode, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceMode->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceMode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.race.mode.index', [], Response::HTTP_SEE_OTHER);
    }
}
