<?php

declare(strict_types=1);

namespace App\Controller\Front\Garage;

use App\Event\Garage\AppUpdateEvent;
use App\Persistence\Entity\GarageApp;
use App\Persistence\Form\Front\Garage\AppUpdateType;
use App\Toolbox\Trait\Controller\WebController;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '/{_locale<%app.supported_locales%>}/garage',
    name: 'app.garage.',
    options: ['expose' => false],
    methods: ['GET', 'POST'],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class UpdateController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /** @description link to the create page */
    private static string $create = 'app.garage.create';

    /** @description link to the delete page */
    private static string $delete = 'app.garage.delete';

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG])]
    public function update(
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $dispatcher,
        GarageApp $entity,
        Request $request,
    ): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.garage');
        $title = $entity->getSettingBrand()->getName() . ' ' . $entity->getModel();

        ### Création du Formulaire
        $form = $this->createForm(AppUpdateType::class, $entity)->handleRequest($request);

        ### Vérification des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                ### Event
                $dispatcher->dispatch(new AppUpdateEvent($entity));

                ### Doctrine
                $entityManager->flush();

                ### Flash Message
                $this->addFlash('success', [
                    'title'   => $this->translator->trans('text.garage'),
                    'message' => sprintf($this->translator->trans('notification.updated'), $title),
                ]);
            } catch (RuntimeException $e) {
                ### Flash Message
                $this->addFlash('danger', [
                    'title'   => $this->translator->trans('text.garage'),
                    'message' => $this->translator->trans('notification.error'),
                ]);

                throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
            }

            ### Launch Command To Generate Garage List YAML
            $this->generateGarageList();

            ### Redirection
            return $this->redirectToRoute(
                'app.garage.update',
                [
                    'id'   => $entity->getId(),
                    'slug' => $entity->getSlug(),
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('@App/contents/front/garage/update.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container-fluid', // container-fluid
            'breadcrumb'      => self::Breadcrump($home, $this->translator->trans('text.update')),
            'links'           => self::LinksPage(),
            'entity'          => $entity,
            'form'            => $form,
        ]);
    }
}
