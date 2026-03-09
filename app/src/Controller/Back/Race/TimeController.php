<?php

declare(strict_types=1);

namespace App\Controller\Back\Race;

use App\Persistence\Entity\RaceTime;
use App\Persistence\Form\Back\RaceTimeType;
use App\Persistence\Repository\RaceTimeRepository;
use App\Toolbox\Trait\Controller\WebController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/race/time',
    name: 'admin.race.time.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class TimeController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index    = 'admin.race.time.index';

    /** @description link to the create page */
    private static string $create   = 'admin.race.time.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.race.time.delete';

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, RaceTimeRepository $repository): Response
    {
        // Variables
        $home  = $this->translator->trans('text.race');
        $title = $this->translator->trans('text.all.times');

        return $this->render('@App/contents/back/race/time.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::getBreadcrump($home, $title),
            'links'           => self::getLinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        // Variables
        $home  = $this->translator->trans('text.race');
        $page  = $this->translator->trans('text.time');
        $title = $this->translator->trans('text.create.time');
        $entity = new RaceTime();
        $form = $this->createForm(RaceTimeType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $page,
                'message' => sprintf($this->translator->trans('notification.created'), $entity->getSlug())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::getBreadcrump($home, $page),
            'links'           => self::getLinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entity,
            'form'            => $form,
        ]);
    }

    #[Route('/update.php/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceTime $entities, EntityManagerInterface $manager): Response
    {
        // Variables
        $home  = $this->translator->trans('text.race');
        $page  = $this->translator->trans('text.time');
        $title = $entities->getName();
        $form  = $this->createForm(RaceTimeType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.time'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getName())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::getBreadcrump($home, $page),
            'links'           => self::getLinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, RaceTime $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.time'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getName())
            ]);
        }

        return $this->redirectToIndex();
    }
}
