<?php

declare(strict_types=1);

namespace App\Controller\Front\Garage;

use App\Event\Garage\AppCreateEvent;
use App\Event\Setting\BrandEvent;
use App\Event\Setting\ClassEvent;
use App\Persistence\Entity\GarageApp;
use App\Persistence\Form\Front\Garage\CreateType;
use App\Toolbox\Trait\Controller\WebController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/garage',
    name: 'app.garage.',
    options: ['expose' => false],
    methods: ['GET', 'POST'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class CreateController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /** @description link to the create page */
    private static string $create = 'app.garage.create';

    /** @description link to the delete page */
    private static string $delete = 'app.garage.delete';

    #[Route('/create.php', name: 'create')]
    public function create(
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $dispatcher,
        Request $request,
    ): Response
    {
        // Variables
        $home  = $this->translator->trans('text.garage');
        $title = $this->translator->trans('text.create.car');

        // Création du formulaire
        $garage = new GarageApp();
        $form = $this->createForm(CreateType::class, $garage)->handleRequest($request);

        // Vérification des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Event
                $dispatcher->dispatch(new BrandEvent($garage));
                $dispatcher->dispatch(new ClassEvent($garage));
                $dispatcher->dispatch(new AppCreateEvent($garage));

                // Doctrine
                $entityManager->persist($garage);
                $entityManager->flush();

                // Flash Message
                $this->addFlash('success', [
                    'title'   => $this->translator->trans('text.garage'),
                    'message' => sprintf(
                        $this->translator->trans('notification.created'),
                        $garage->getSettingBrand()->getName() . ' ' . $garage->getModel()
                    )
                ]);
            } catch (\RuntimeException $e) {
                // Flash Message
                $this->addFlash('danger', [
                    'title'   => $this->translator->trans('text.garage'),
                    'message' => $this->translator->trans('notification.error'),
                ]);

                throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
            }

            // Redirection
            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/front/garage/create.html.twig', [
            'controller_name'  => $title,
            'current_page'     => $request->attributes->get('_route'),
            'container'        => 'container',
            'breadcrumb'       => self::getBreadcrump($home, $title),
            'links'            => self::getLinksPage(),
            'garage'           => $garage,
            'game_update_last' => $entityManager->getRepository(GarageApp::class)->getLastUpdate(),
            'form'             => $form,
        ]);
    }
}
