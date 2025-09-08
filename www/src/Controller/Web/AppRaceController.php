<?php

namespace App\Controller\Web;

use App\Entity\AppRace;
use App\Form\App\RaceType;
use App\Repository\AppRaceRepository;
use App\Service\Cache\RaceCacheService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/race', name: 'app.race.', options: ['expose' => true], format: 'html', utf8: true)]
final class AppRaceController extends AbstractController
{
    public function __construct(
        private readonly RaceCacheService  $cacheService,
        private readonly TranslatorInterface $translator
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(AppRaceRepository $repository): Response
    {
        $title  = $this->translator->trans('controllerName.app.race.index');

        return $this->render('@App/app/race/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'app.race.index',
            'create'          => 'app.race.create',
            'races'           => $this->cacheService->createDataCache('races')['index'],
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $appRace = new AppRace();
        $form = $this->createForm(RaceType::class, $appRace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appRace);
            $entityManager->flush();

            return $this->redirectToRoute('app.race.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.app.race.create');

        return $this->render('@App/app/race/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'app.race.index',
            'current'         => $request->attributes->get('_route'),
            'app_race'        => $appRace,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, AppRace $appRace, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaceType::class, $appRace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app.race.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.app.race.update');

        return $this->render('@App/app/race/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'app.race.index',
            'current'         => $request->attributes->get('_route'),
            'app_race'        => $appRace,
            'form'            => $form,
        ]);
    }

    #[Route('/read/{id}', name: 'read', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET'])]
    public function read(AppRace $appRace): Response
    {
        return $this->render('@App/app/garage/read.html.twig', [
            'controller_name' => $this->translator->trans('controllerName.app.race.read'),
            'app_garage'      => $appRace,

        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, AppRace $appRace, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appRace->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($appRace);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app.race.index', [], Response::HTTP_SEE_OTHER);
    }
}
