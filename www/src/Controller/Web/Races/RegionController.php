<?php

namespace App\Controller\Web\Races;

use App\Entity\RaceRegion;
use App\Form\Races\RegionType;
use App\Repository\RaceRegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/races/region', name: 'admin.race.region.', options: ['expose' => true], format: 'html', utf8: true)]
final class RegionController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(RaceRegionRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.region.index');

        return $this->render('@App/admin/races/region/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.region.index',
            'create'          => 'admin.race.region.create',
            'regions'         => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceRegion = new RaceRegion();
        $form = $this->createForm(RegionType::class, $raceRegion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceRegion);
            $entityManager->flush();

            return $this->redirectToRoute('admin.race.region.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.region.create');

        return $this->render('@App/admin/races/region/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'           => 'admin.race.region.index',
            'current'         => $request->attributes->get('_route'),
            'race_region'     => $raceRegion,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceRegion $raceRegion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegionType::class, $raceRegion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.race.region.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.region.update');

        return $this->render('@App/admin/races/region/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'           => 'admin.race.region.index',
            'current'         => $request->attributes->get('_route'),
            'race_region'     => $raceRegion,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, RaceRegion $raceRegion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceRegion->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceRegion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.race.region.index', [], Response::HTTP_SEE_OTHER);
    }
}
