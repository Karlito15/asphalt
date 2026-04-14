<?php

declare(strict_types=1);

namespace App\Application\Controller\Back\Race;

use App\Application\Service\Controller\WebController;
use App\Domain\Entity\RaceApp;
use App\Domain\Form\Back\RaceAppType;
use App\Domain\Repository\RaceAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/race/app',
    name: 'admin.race.app.',
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
      'index'  => 'admin.race.app.index',
      'create' => 'admin.race.app.create',
      'read'   => null,
      'update' => 'admin.race.app.update',
      'delete' => 'admin.race.app.delete',
    ];

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, RaceAppRepository $repository): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.race');
        $title = $this->translator->trans('text.all.races');

        return $this->render('@App/contents/back/race/app.html.twig', [
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
        $home   = $this->translator->trans('text.race');
        $title  = $this->translator->trans('text.create.race');
        $entity = new RaceApp();
        $form   = $this->createForm(RaceAppType::class, $entity)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'success',
                message: sprintf($this->translator->trans('notification.created'), $entity->getSlug())
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
    public function update(Request $request, RaceApp $entities, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.race');
        $title = $entities->getSlug();
        $form  = $this->createForm(RaceAppType::class, $entities)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'info',
                message: sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getSlug())
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
    public function delete(Request $request, RaceApp $entities, EntityManagerInterface $manager): Response
    {
        ### Forms
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'error',
                message: sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getSlug())
            );
        }

        return $this->redirectToIndex();
    }
}
