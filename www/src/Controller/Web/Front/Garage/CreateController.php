<?php

namespace App\Controller\Web\Front\Garage;

use App\Able\Controller\WebAble;
use App\Entity\GarageApp;
use App\Event\Garage\CreateEvent;
use App\Event\Setting\BrandEvent;
use App\Event\Setting\ClassEvent;
use App\Form\Front\Garage\AppCreateType;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/garage', name: 'app.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
//#[Route('/garage', name: 'app.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class CreateController extends AbstractController
{
    use WebAble;

    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /** @description link to the create page */
    private static string $create = 'app.garage.create';

    /** @description link to the delete page */
    private static string $delete = 'app.garage.delete';

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param EventDispatcherInterface $dispatcher
     * @param TranslatorInterface $translator
     * @return Response
     * @throws RuntimeException
     */
    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $dispatcher,
        TranslatorInterface $translator,
    ): Response
    {
        $title = $translator->trans('app.garage.create.title');

        // Création du formulaire
        $garage = new GarageApp();
        $form = $this->createForm(AppCreateType::class, $garage)->handleRequest($request);

        // Vérification des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Events
                $dispatcher->dispatch(new BrandEvent($garage));
                $dispatcher->dispatch(new ClassEvent($garage));
                $dispatcher->dispatch(new CreateEvent($garage));
                // Doctrines
                $entityManager->persist($garage);
                $entityManager->flush();
                // Flash
                $message = sprintf($translator->trans('app.flash.garage.create') . ' : %1$s %2$s', $garage->getSettingBrand(), $garage->getModel());
                $this->addFlash('success', $message);
            } catch (RuntimeException $e) {
                // Flash
                $this->addFlash('danger', $translator->trans('app.flash.error'));
                throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
            }

            // Redirection
            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/front/garage/create.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'Garage', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'garage'            => $garage,
            'game_update_last'  => $entityManager->getRepository(GarageApp::class)->getLastUpdate(),
            'form'              => $form,
        ]);
    }
}
