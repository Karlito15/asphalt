<?php

namespace App\Controller\Back\Race;

use App\Entity\RaceTrack;
use App\Form\Back\RaceTrackType;
use App\Repository\RaceTrackRepository;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/race/track', name: 'admin.race.track.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class TrackController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index    = 'admin.race.track.index';

    /** @description link to the create page */
    private static string $create   = 'admin.race.track.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.race.track.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, RaceTrackRepository $repository): Response
    {
        $title = $this->translator->trans('text.all.tracks');

        return $this->render('@App/back/contents/race/track.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => $this->translator->trans('text.back-office'), 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $title = $this->translator->trans('text.create.track');
        $entities = new RaceTrack();
        $form = $this->createForm(RaceTrackType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $this->translator->trans('text.track'),
                'message' => sprintf($this->translator->trans('notification.created'), $entities->getId(), $entities->getNameEnglish())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => $this->translator->trans('text.track'), 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceTrack $entities, EntityManagerInterface $manager): Response
    {
        $title = $entities->getNameEnglish();
        $form = $this->createForm(RaceTrackType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.track'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getNameEnglish())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => $this->translator->trans('text.track'), 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, RaceTrack $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.track'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getNameEnglish())
            ]);

        }

        return $this->redirectToIndex();
    }
}
