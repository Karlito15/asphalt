<?php

namespace App\Controller\Web\Front;

use App\Able\Controller\WebAble;
use App\Entity\MissionApp;
use App\Form\MissionAppType;
use App\Repository\MissionAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/mission', name: 'app.mission.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class MissionAppController extends AbstractController
{
    use WebAble;

    /** @description link to the index page */
    private static string $index = 'app.mission.index';

    /** @description link to the create page */
    private static string $create = 'app.mission.create';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, MissionAppRepository $repository): Response
    {
        $title = $this->translator->trans('app.mission.index.title');

        return $this->render('@App/contents/front/mission/index.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => $title,
            'links'             => self::getLinksPage(),
            'entities'          => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $title = $this->translator->trans('app.mission.create.title');

        $missionApp = new MissionApp();
        $form = $this->createForm(MissionAppType::class, $missionApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($missionApp);
            $entityManager->flush();

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/front/mission/form.html.twig', [
            'controller_name' => $title,
            'current_page'      => $request->attributes->get('_route'),
            'mission_app' => $missionApp,
            'form' => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, MissionApp $missionApp, EntityManagerInterface $entityManager): Response
    {
        $title = $this->translator->trans('app.mission.update.title');

        $form = $this->createForm(MissionAppType::class, $missionApp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/front/mission/form.html.twig', [
            'controller_name' => $title,
            'current_page'      => $request->attributes->get('_route'),
            'mission_app' => $missionApp,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}.php', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, MissionApp $missionApp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionApp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($missionApp);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
    }
}
