<?php

namespace App\Controller\Front\Garage;

use App\Entity\GarageApp;
use App\Event\Garage\CreateEvent;
use App\Event\Setting\BrandEvent;
use App\Event\Setting\ClassEvent;
use App\Form\Front\GarageAppCreateType;
use App\Service\Cache\GarageAppService;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/garage', name: 'app.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class CreateController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /** @description link to the create page */
    private static string $create = 'app.garage.create';

    /** @description link to the delete page */
    private static string $delete = 'app.garage.delete';

    /**
     * @param GarageAppService $service
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param EventDispatcherInterface $dispatcher
     * @param TranslatorInterface $translator
     * @return Response
     */
    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(
        GarageAppService $service,
        Request $request,
        EntityManagerInterface $manager,
        EventDispatcherInterface $dispatcher,
        TranslatorInterface $translator,
    ): Response
    {
        // Variables
        $title = $translator->trans('text.create.car');

        // Création du formulaire
        $garage = new GarageApp();
        $form = $this->createForm(GarageAppCreateType::class, $garage)->handleRequest($request);

        // Vérification des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Event
                $dispatcher->dispatch(new BrandEvent($garage));
                $dispatcher->dispatch(new ClassEvent($garage));
                $dispatcher->dispatch(new CreateEvent($garage));

                // Doctrine
                $manager->persist($garage);
                $manager->flush();

                // Cache
                $service->cacheDelete();

                // Flash Message
                $this->addFlash('success', [
                    'title' => $translator->trans('text.garage'),
                    'message' => sprintf(
                        $translator->trans('notification.created'),
                        $garage->getSettingBrand()->getName() . ' ' . $garage->getModel()
                    )
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
            return $this->redirectToIndex();
        }

        return $this->render('@App/front/contents/garage/create.html.twig', [
            'controller_name'  => $title,
            'current_page'     => $request->attributes->get('_route'),
            'container'        => 'container',
            'breadcrumb'       => ['level1' => $translator->trans('text.garage'), 'level2' => $title],
            'links'            => self::getLinksPage(),
            'garage'           => $garage,
            'game_update_last' => $manager->getRepository(GarageApp::class)->getLastUpdate(),
            'form'             => $form,
        ]);
    }
}
