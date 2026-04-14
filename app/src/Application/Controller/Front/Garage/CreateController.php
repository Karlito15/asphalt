<?php

declare(strict_types=1);

namespace App\Application\Controller\Front\Garage;

use App\Application\Service\Controller\WebController;
use App\Domain\Entity\GarageApp;
use App\Domain\Form\Front\Garage\AppCreateType;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
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

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'app.garage.index',
      'create' => 'app.garage.create',
      'read'   => 'app.garage.read',
      'update' => 'app.garage.update',
      'delete' => 'app.garage.delete',
    ];

    #[Route('/create.php', name: 'create')]
    public function create(
        EntityManagerInterface $manager,
        EventDispatcherInterface $dispatcher,
        Request $request,
    ): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.garage');
        $title = $this->translator->trans('text.create.car');

        ### Création du formulaire
        $garage = new GarageApp();
        $form   = $this->createForm(AppCreateType::class, $garage)->handleRequest($request);

        ### Vérification des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                ### Events
//                $dispatcher->dispatch(new BrandEvent($garage));
//                $dispatcher->dispatch(new ClassEvent($garage));
//                $dispatcher->dispatch(new AppCreateEvent($manager, $garage));

                ### Doctrine
                $manager->persist($garage);
                $manager->flush();

                ### Flash Message
                $this->addFlash(
                    type:'success',
                    message: sprintf($this->translator->trans('notification.created'), $garage->getSettingBrand()->getName() . ' ' . $garage->getModel())
                );
            } catch (RuntimeException $e) {
                ### Flash Message
                $this->addFlash(
                    type:'error',
                    message: $this->translator->trans('notification.error')
                );

                throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
            }

//            ### Launch Command To Generate Garage List YAML
//            $this->generateGarageList();

            ### Redirection
            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/front/garage/create.html.twig', [
            'container'        => 'container',
            'breadcrumb'       => self::Breadcrumb($home, $title),
            'links'            => self::$crud,
            'controller_name'  => $title,
            'current_page'     => $request->attributes->get('_route'),
            'garage'           => $garage,
            'game_update_last' => $manager->getRepository(GarageApp::class)->getLastUpdate(),
            'form'             => $form,
        ]);
    }
}
