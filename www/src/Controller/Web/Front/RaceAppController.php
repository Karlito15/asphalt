<?php

namespace App\Controller\Web\Front;

use App\Able\Controller\WebAble;
use App\Entity\RaceApp;
use App\Form\Front\RaceAppType;
use App\Repository\RaceAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/race', name: 'app.race.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class RaceAppController extends AbstractController
{
    use WebAble;

    /** @description link to the index page */
    private static string $index = 'app.race.index';

    /** @description link to the create page */
    private static string $create = 'app.race.create';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, RaceAppRepository $repository): Response
    {
        $title = $this->translator->trans('app.race.index.title');

        return $this->render('@App/contents/front/race/index.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'XXXX', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $title = $this->translator->trans('app.race.create.title');

        $raceApp = new RaceApp();
        $form = $this->createForm(RaceAppType::class, $raceApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raceApp);
            $entityManager->flush();

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/front/race/form.html.twig', [
            'controller_name' => $title,
            'current_page'      => $request->attributes->get('_route'),
            'race_app' => $raceApp,
            'form' => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, RaceApp $raceApp, EntityManagerInterface $entityManager): Response
    {
        $title = $this->translator->trans('app.race.update.title');

        $form = $this->createForm(RaceAppType::class, $raceApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/front/race/form.html.twig', [
            'controller_name' => $title,
            'current_page'      => $request->attributes->get('_route'),
            'race_app' => $raceApp,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, RaceApp $raceApp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raceApp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raceApp);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
    }
}
