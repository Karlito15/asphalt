<?php

namespace App\Controller\Front\Garage;

use App\Entity\GarageApp;
use App\Event\Garage\UpdateEvent;
use App\Form\Front\GarageAppUpdateType;
use App\Service\Cache\GarageAppService;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/garage', name: 'app.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class UpdateController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /** @description link to the create page */
    private static string $create = 'app.garage.create';

    /** @description link to the delete page */
    private static string $delete = 'app.garage.delete';

    /**
     * @param Request $request
     * @param GarageApp $entity
     * @param GarageAppService $cache
     * @param EntityManagerInterface $manager
     * @param EventDispatcherInterface $dispatcher
     * @param TranslatorInterface $translator
     * @return Response
     */
    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(
        Request $request,
        GarageApp $entity,
        GarageAppService $cache,
        EntityManagerInterface $manager,
        EventDispatcherInterface $dispatcher,
        TranslatorInterface $translator,
    ): Response
    {
        // Variables
        $car   = $entity->getSettingBrand()->getName() . ' ' . $entity->getModel();

        // Création du Formulaire
        $form = $this->createForm(GarageAppUpdateType::class, $entity)->handleRequest($request);

        // Vérification des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Event
                $dispatcher->dispatch(new UpdateEvent($entity));

                // Doctrine
                $manager->flush();

                // Cache
                $cache->cacheDelete();

                // Flash Message
                $this->addFlash('info', [
                    'title' => $translator->trans('text.garage'),
                    'message' => sprintf($translator->trans('notification.updated'), $car)
                ]);

            } catch (RuntimeException $e) {
                // Flash Message
                $this->addFlash('danger', [
                    'title' => $translator->trans('text.garage'),
                    'message' => $translator->trans('notification.error'),
                ]);
                throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
            }

            // Redirection
             return $this->redirectToRoute('app.garage.update', ['slug' => $entity->getSlug(), 'id' => $entity->getId()]);
        }

        // Logs
//        $logApp         = $manager->getRepository(LogEntry::class)->getLogEntries($entity);
//        $logBlue        = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getBlueprint()->getValues()[0]);
//        $logGauntlet    = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getGauntlet()->getValues()[0]);
//        $logRank        = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getRank()->getValues()[0]);
//        $logStatus      = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getStatus()->getValues()[0]);
//        $logActual      = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getStatActual()->getValues()[0]);
//        $logMax         = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getStatMax()->getValues()[0]);
//        $logMin         = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getStatMin()->getValues()[0]);
//        $logUpgrades    = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getUpgrade()->getValues()[0]);
//        $logBlueprint   = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getSettingBlueprint());
//        $logBrand       = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getSettingBrand());
//        $logClass       = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getSettingClass());
//        $logLevel       = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getSettingLevel());
//        $logPrice       = $manager->getRepository(LogEntry::class)->getLogEntries($entity->getSettingUnitPrice());
//        $logs           = array_merge($logApp,
//            $logBlue, $logGauntlet, $logRank, $logStatus, $logActual, $logMax, $logMin, $logUpgrades,
//            $logBlueprint, $logBrand, $logClass, $logLevel, $logPrice
//        );
//        /** @var LogEntry $logs */
//        dd($logs[0]->getLoggedAt()->format('Y-m-d H:i'));

        return $this->render('@App/front/contents/garage/update.html.twig', [
            'controller_name' => $car,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container-fluid', // container-fluid
            'breadcrumb'      => ['level1' => $translator->trans('text.garage'), 'level2' => $translator->trans('text.update')],
            'links'           => self::getLinksPage(),
            'entity'          => $entity,
            'form'            => $form,
            'car'             => $car,
        ]);
    }

    /**
     * @param Request $request
     * @param GarageApp $garage
     * @param EntityManagerInterface $manager
     * @param TranslatorInterface $translator
     * @return Response
     */
    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, GarageApp $garage, EntityManagerInterface $manager, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garage->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($garage);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $translator->trans('text.garage'),
                'message' => sprintf($translator->trans('notification.deleted'),
                    $garage->getSettingBrand()->getName() . " " . $garage->getModel()
                )
            ]);
        }

        return $this->redirectToIndex();
    }
}
