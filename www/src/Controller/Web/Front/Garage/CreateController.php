<?php

namespace App\Controller\Web\Front\Garage;

use App\Entity\GarageApp;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}/garage', name: 'app.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class CreateController extends AbstractController
{
    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param EventDispatcherInterface $dispatcher
     * @param TranslatorInterface $translator
     * @return Response
     * @throws Exception
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

        /** Création du Formulaire */
        $garage = new GarageApp();
        $form = $this->createForm(AppCreateType::class, $garage)->handleRequest($request);

        /** Vérification des données du formulaire */
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                /** Events */
                $dispatcher->dispatch(new SettingBrandEvent($garage));
                $dispatcher->dispatch(new SettingClassEvent($garage));
                $dispatcher->dispatch(new GarageCreateEvent($garage));
                /** Doctrines */
                $entityManager->persist($garage);
                $entityManager->flush();
                /** Flash */
                $message = sprintf($translator->trans('app.garage.create.flash') . ' : %1$s %2$s', $garage->getSettingBrand(), $garage->getModel());
                $this->addFlash('success', $message);
            } catch (Exception $e) {
                /** Flash */
                $this->addFlash('danger', 'Houston, we have a problem !');
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }

            /** Redirection */
            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/front/garage/create.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => $translator->trans('app.garage.index.title'), 'level2' => $title],
            'links'             => ['index' => self::$index],
            'garage'            => $garage,
            'game_update_last'  => $entityManager->getRepository(GarageApp::class)->getLastUpdate(),
            'form'              => $form,
        ]);
    }
}
