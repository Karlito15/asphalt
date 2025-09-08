<?php

namespace App\Controller\Web\Races;

use App\Entity\RaceTime;
use App\Form\Races\TimeType;
use App\Repository\RaceTimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/races/time', name: 'admin.race.time.', options: ['expose' => true], format: 'html', utf8: true)]
final class TimeController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(RaceTimeRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.time.index');

        return $this->render('@App/admin/races/time/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.time.index',
            'create'          => 'admin.race.time.create',
            'times'           => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raceTime = new RaceTime();
        $form = $this->createForm(TimeType::class, $raceTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceTime);
            $entityManager->flush();

            return $this->redirectToRoute('admin.race.time.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.time.create');

        return $this->render('@App/admin/races/time/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.time.index',
            'current'         => $request->attributes->get('_route'),
            'race_time'       => $raceTime,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceTime $raceTime, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TimeType::class, $raceTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.race.time.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.time.update');

        return $this->render('@App/admin/races/time/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.race.time.index',
            'current'         => $request->attributes->get('_route'),
            'race_time'       => $raceTime,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, RaceTime $raceTime, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceTime->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceTime);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.race.time.index', [], Response::HTTP_SEE_OTHER);
    }
}
