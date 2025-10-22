<?php

namespace App\Controller\Back;

use App\Entity\RaceApp;
use App\Form\Front\RaceAppType;
use App\Service\Cache\RaceAppService;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/admin/race', name: 'admin.race.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class RaceController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index = 'admin.race.index';

    /** @description link to the create page */
    private static string $create = 'admin.race.create';

    /** @description link to the delete page */
    private static string $delete = 'admin.race.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly RaceAppService $service,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $title = $this->translator->trans('text.all.races');

        return $this->render('@App/back/contents/race/race.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.race'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'entities'        => $this->service->cacheCreate(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $title = $this->translator->trans('text.create.race');
        $entities = new RaceApp();
        $form = $this->createForm(RaceAppType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $this->translator->trans('text.race'),
                'message' => sprintf($this->translator->trans('notification.created'), $entities->getSlug())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.race'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'race_app'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceApp $entities, EntityManagerInterface $manager): Response
    {
        $title = $entities->getSlug();

        $form = $this->createForm(RaceAppType::class, $entities);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.race'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getSlug())
            ]);

            $this->service->cacheDelete();

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.race'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'race_app'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, RaceApp $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.race'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getSlug())
            ]);

            $this->service->cacheDelete();
        }

        return $this->redirectToIndex();
    }
}
