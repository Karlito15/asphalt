<?php

namespace App\Controller\Web\Back\Race;

use App\Able\Controller\WebAble;
use App\Entity\RaceMode;
use App\Form\Back\RaceModeType;
use App\Repository\RaceModeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/race/mode', name: 'app.race.mode.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class ModeController extends AbstractController
{
    use WebAble;

    /** @description link to the index page */
    private static string $index    = 'app.race.mode.index';

    /** @description link to the create page */
    private static string $create   = 'app.race.mode.create';

    /** @description link to the delete page */
    private static string $delete   = 'app.race.mode.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, RaceModeRepository $repository): Response
    {
        $title = $this->translator->trans('app.race.mode.index.title');

        return $this->render('@App/contents/back/race/mode.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'Mode', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $title = $this->translator->trans('app.race.mode.create.title');
        $entities = new RaceMode();
        $form = $this->createForm(RaceModeType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entities);
            $entityManager->flush();

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/back/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'Mode', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceMode $entities, EntityManagerInterface $entityManager): Response
    {
        $title = $this->translator->trans('app.race.mode.update.title');
        $form = $this->createForm(RaceModeType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/back/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'Mode', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, RaceMode $entities, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($entities);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
    }
}
