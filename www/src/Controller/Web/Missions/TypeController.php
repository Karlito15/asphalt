<?php

namespace App\Controller\Web\Missions;

use App\Entity\MissionType;
use App\Form\Missions\TypeType;
use App\Repository\MissionTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/missions/type', name: 'admin.mission.type.', options: ['expose' => true], format: 'html', utf8: true)]
final class TypeController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(MissionTypeRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.type.index');

        return $this->render('@App/admin/missions/type/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Mission', 'lvl2' => $title],
            'index'           => 'admin.mission.type.index',
            'create'          => 'admin.mission.type.create',
            'types'           => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $missionType = new MissionType();
        $form = $this->createForm(TypeType::class, $missionType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($missionType);
            $entityManager->flush();

            return $this->redirectToRoute('admin.mission.type.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.type.create');

        return $this->render('@App/admin/missions/type/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Mission', 'lvl2' => $title],
            'index'           => 'admin.mission.type.index',
            'current'         => $request->attributes->get('_route'),
            'mission_type'    => $missionType,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, MissionType $missionType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeType::class, $missionType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.mission.type.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.type.update');

        return $this->render('@App/admin/missions/type/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Mission', 'lvl2' => $title],
            'index'           => 'admin.mission.type.index',
            'current'         => $request->attributes->get('_route'),
            'mission_type'    => $missionType,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, MissionType $missionType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionType->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($missionType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.mission.type.index', [], Response::HTTP_SEE_OTHER);
    }
}
