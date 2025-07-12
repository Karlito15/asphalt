<?php

namespace App\Controller\Web\Front\Garage;

use App\Able\Controller\WebAble;
use App\Entity\GarageApp;
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

#[Route('/{_locale<%app.supported_locales%>}/garage', name: 'app.garage.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class UpdateController extends AbstractController
{
    use WebAble;

    /** @description link to the index page */
    private static string $index = 'app.garage.index';

    /** @description link to the create page */
    private static string $create = 'app.garage.create';

    /**
     * @param Request $request
     * @param GarageApp $garage
     * @param GarageService $cache
     * @param EntityManagerInterface $entityManager
     * @param EventDispatcherInterface $dispatcher
     * @param TranslatorInterface $translator
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(
        Request $request,
        GarageApp $garage,
        GarageService $cache,
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $dispatcher,
        TranslatorInterface $translator,
    ): Response
    {
        $car   = $garage->getSettingBrand()->getName() . " " . $garage->getModel();
        $title = $translator->trans('app.garage.update.title') . $car;

        /** Création du Formulaire */
        $form = $this->createForm(AppUpdateType::class, $garage)->handleRequest($request);

        /** Vérification des données du formulaire */
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                /** Events */
                $dispatcher->dispatch(new GarageOrderCarEvent($garage));
//                $dispatcher->dispatch(new GarageTagEvent($garage));
                /** Doctrines */
                $entityManager->flush();
                /** Flash */
                $message = sprintf('%1$s %2$s' . $translator->trans('app.garage.update.flash'), $garage->getSettingBrand(), $garage->getModel());
                $this->addFlash('success', $message);
                /** Cache : delete items for Dashboard */
                $cache->deleteDataCache();
            } catch (Exception $e) {
                /** Flash */
                $this->addFlash('danger', 'Houston, we have a problem !');
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }

            /** Redirection */
            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/front/garage/update.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'Garage', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'garage'            => $garage,
            'form'              => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, GarageApp $garage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garage->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($garage);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
    }
}
