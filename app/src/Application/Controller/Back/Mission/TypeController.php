<?php

declare(strict_types=1);

namespace App\Application\Controller\Back\Mission;

use App\Application\Service\Controller\WebController;
use App\Domain\Entity\MissionType;
use App\Domain\Form\Back\MissionTypeType;
use App\Domain\Repository\MissionTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/mission/type',
    name: 'admin.mission.type.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class TypeController extends AbstractController
{
    use WebController;

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'admin.mission.type.index',
      'create' => 'admin.mission.type.create',
      'read'   => null,
      'update' => 'admin.mission.type.update',
      'delete' => 'admin.mission.type.delete',
    ];

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, MissionTypeRepository $repository): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.mission');
        $title = $this->translator->trans('text.all.types');

        return $this->render('@App/theme-aero/contents/back/mission/common.html.twig', [
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
        $home   = $this->translator->trans('text.mission');
        $page   = $this->translator->trans('text.type');
        $title  = $this->translator->trans('text.create.type');
        $entity = new MissionType();
        $form   = $this->createForm(MissionTypeType::class, $entity)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'success',
                message: sprintf($this->translator->trans('notification.created'), $entity->getValue())
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
    public function update(Request $request, MissionType $entities, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.mission');
        $page  = $this->translator->trans('text.type');
        $title = $entities->getValue();
        $form  = $this->createForm(MissionTypeType::class, $entities)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'info',
                message: sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getValue())
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
    public function delete(Request $request, MissionType $entities, EntityManagerInterface $manager): Response
    {
        ### Forms
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'error',
                message: sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getValue())
            );
        }

        return $this->redirectToIndex();
    }
}
