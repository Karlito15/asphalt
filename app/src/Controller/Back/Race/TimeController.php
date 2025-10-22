<?php

namespace App\Controller\Back\Race;

use App\Entity\RaceTime;
use App\Form\Back\RaceTimeType;
use App\Repository\RaceTimeRepository;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/race/time', name: 'admin.race.time.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class TimeController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index    = 'admin.race.time.index';

    /** @description link to the create page */
    private static string $create   = 'admin.race.time.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.race.time.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, RaceTimeRepository $repository): Response
    {
        $title = $this->translator->trans('text.all.times');

        return $this->render('@App/back/contents/race/time.html.twig', [
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
        $title = $this->translator->trans('text.create.time');
        $entities = new RaceTime();
        $form = $this->createForm(RaceTimeType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $this->translator->trans('text.time'),
                'message' => sprintf($this->translator->trans('notification.created'), $entities->getId(), $entities->getName())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => $this->translator->trans('text.time'), 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceTime $entities, EntityManagerInterface $manager): Response
    {
        $title = $entities->getName();
        $form = $this->createForm(RaceTimeType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.time'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getName())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => $this->translator->trans('text.time'), 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/delete/{id}.php', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
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
