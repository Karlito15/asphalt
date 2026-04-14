<?php

declare(strict_types=1);

namespace App\Application\Controller\Back\Mission;

use App\Application\Service\Controller\WebController;
use App\Domain\Entity\MissionApp;
use App\Domain\Form\Back\MissionAppType;
use App\Domain\Repository\MissionAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/mission/app',
    name: 'admin.mission.app.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class AppController extends AbstractController
{
    use WebController;

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'admin.mission.app.index',
      'create' => 'admin.mission.app.create',
      'read'   => null,
      'update' => 'admin.mission.app.update',
      'delete' => 'admin.mission.app.delete',
    ];

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, MissionAppRepository $repository): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.mission');
        $title = $this->translator->trans('text.all.missions');

        return $this->render('@App/contents/back/mission/app.html.twig', [
            'container'       => 'container-fluid',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => self::$crud,
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.mission');
        $title  = $this->translator->trans('text.create.mission');
        $entity = new MissionApp();
        $form   = $this->createForm(MissionAppType::class, $entity)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'success',
                message: sprintf($this->translator->trans('notification.created'), $entity->getDescription())
            );

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/common-form.html.twig', [
            'container'       => 'container-fluid',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => self::$crud,
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $entity,
            'form'            => $form,
        ]);
    }

    #[Route('/update.php/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, MissionApp $entities, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.mission');
        $title = $entities->getDescription();
        $form  = $this->createForm(MissionAppType::class, $entities)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'info',
                message: sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getDescription())
            );

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/common-form.html.twig', [
            'container'       => 'container-fluid',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => self::$crud,
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete.php/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, MissionApp $entities, EntityManagerInterface $manager): Response
    {
        ### Forms
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'error',
                message: sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getDescription())
            );
        }

        return $this->redirectToIndex();
    }
}
