<?php

namespace App\Controller\Web\Races;

use App\Entity\RaceSeason;
use App\Form\Races\SeasonType;
use App\Repository\RaceSeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/races/season', name: 'admin.race.season.', options: ['expose' => true], format: 'html', utf8: true)]
final class SeasonController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(RaceSeasonRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.season.index');

        return $this->render('@App/admin/races/season/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.season.index',
            'create'          => 'admin.race.season.create',
            'seasons'         => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceSeason = new RaceSeason();
        $form = $this->createForm(SeasonType::class, $raceSeason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceSeason);
            $entityManager->flush();

            return $this->redirectToRoute('admin.race.season.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.season.create');

        return $this->render('@App/admin/races/season/form.html.twig', [
            'controller_name' => $this->translator->trans('controllerName.admin.season.create'),
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.season.index',
            'current'         => $request->attributes->get('_route'),
            'race_season'     => $raceSeason,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceSeason $raceSeason, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SeasonType::class, $raceSeason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.race.season.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.season.update');

        return $this->render('@App/admin/races/season/form.html.twig', [
            'controller_name' => $this->translator->trans('controllerName.admin.season.update'),
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.season.index',
            'current'         => $request->attributes->get('_route'),
            'race_season'     => $raceSeason,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, RaceSeason $raceSeason, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceSeason->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceSeason);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.race.season.index', [], Response::HTTP_SEE_OTHER);
    }
}
