<?php

namespace App\Controller\Web;

use App\Entity\AppGarage;
use App\Event\BooleanGarageEvent;
use App\Event\GarageCreateEvent;
use App\Event\OrderCarGarageEvent;
use App\Event\SettingBrandEvent;
use App\Event\SettingClassEvent;
use App\Form\App\GarageCreateType;
use App\Form\App\GarageUpdateType;
use App\Repository\AppGarageRepository;
use App\Service\Cache\GarageCacheService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/garage', name: 'app.garage.', options: ['expose' => true], format: 'html', utf8: true)]
final class AppGarageController extends AbstractController
{
    public function __construct(
        private readonly AppGarageRepository        $repository,
        private readonly EntityManagerInterface     $entityManager,
        private readonly EventDispatcherInterface   $dispatcher,
        private readonly GarageCacheService         $cacheService,
        private readonly TranslatorInterface        $translator,
    ) {}

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/index.html', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $title = $this->translator->trans('controllerName.app.garage.index');

        return $this->render('@App/app/garage/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Garage', 'lvl2' => $title],
            'index'           => 'app.garage.index',
            'create'          => 'app.garage.create',
            'garages'         => $this->cacheService->createDataCache('garages')['index'],
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        /** Création du Formulaire */
        $garage = new AppGarage();
        $form   = $this->createForm(GarageCreateType::class, $garage)->handleRequest($request);

        /** Vérification des données du formulaire */
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                /** Events */
                $this->dispatcher->dispatch(new SettingBrandEvent($garage));
                $this->dispatcher->dispatch(new SettingClassEvent($garage));
                $this->dispatcher->dispatch(new GarageCreateEvent($garage));
                $this->entityManager->persist($garage);
                $this->entityManager->flush();
                $this->entityManager->clear();

                /** Flash */
                $message = sprintf('Une nouvelle voiture est enregistrée dans le garage : %1$s %2$s', $garage->getSettingBrand(), $garage->getModel());
                $this->addFlash('success', $message);
            } catch (Exception $e) {
                /** Flash */
                $this->addFlash('danger', 'Houston, we have a problem !');
                throw new Exception($e->getMessage());
            }

            return $this->redirectToRoute('app.garage.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.app.garage.create');

        return $this->render('@App/app/garage/create.html.twig', [
            'controller_name'   => $title,
            'breadcrumb'        => ['lvl1' => 'Garage', 'lvl2' => $title],
            'index'             => 'app.garage.index',
            'current'           => $request->attributes->get('_route'),
            'game_update_last'  => $this->repository->getLastUpdate(),
            'form'              => $form,
        ]);
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, AppGarage $garage): Response
    {
        /** Création du Formulaire */
        $form = $this->createForm(GarageUpdateType::class, $garage)->handleRequest($request);

        /** Vérification des données du formulaire */
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                /** Events */
                $this->dispatcher->dispatch(new OrderCarGarageEvent($garage));
                $this->dispatcher->dispatch(new BooleanGarageEvent($garage));
                $this->entityManager->flush();
                $this->entityManager->clear();

                /** Cache : delete items for Dashboard */
                $this->cacheService->deleteDataCache();

                /** Flash */
                $this->addFlash('success', $garage->getSettingBrand()->getName() . ' ' . $garage->getModel() . ' a été mise à jour !');
            } catch (Exception $e) {
                /** Flash */
                $this->addFlash('danger', 'Houston, we have a problem !');
                throw new Exception($e->getMessage());
            }

            return $this->redirectToRoute('app.garage.update', ['id' => $garage->getId(), 'slug' => $garage->getSlug()], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.app.garage.update') . $garage->getSettingBrand()->getName() . ' ' . $garage->getModel();

        return $this->render('@App/app/garage/update.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Garage', 'lvl2' => $title],
            'index'           => 'app.garage.index',
            'current'         => $request->attributes->get('_route'),
            'garage'          => $garage,
            'form'            => $form,
        ]);
    }

    #[Route('/read/{slug}-{id}.php', name: 'read', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET'])]
    public function read(Request $request, AppGarage $garage): Response
    {
        $title = $this->translator->trans('controllerName.app.garage.read') . $garage->getSettingBrand()->getName() . ' ' . $garage->getModel();

        return $this->render('@App/app/garage/read.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Garage', 'lvl2' => $title],
            'index'           => 'app.garage.index',
            'current'         => $request->attributes->get('_route'),
            'garage'          => $garage,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, AppGarage $appGarage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appGarage->getId(), $request->getPayload()->getString('_token'))) {
            $this->entityManager->remove($appGarage);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app.garage.index', [], Response::HTTP_SEE_OTHER);
    }
}
