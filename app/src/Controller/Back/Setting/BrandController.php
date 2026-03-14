<?php

declare(strict_types=1);

namespace App\Controller\Back\Setting;

use App\Persistence\Entity\SettingBrand;
use App\Persistence\Form\Back\SettingBrandType;
use App\Persistence\Repository\SettingBrandRepository;
use App\Toolbox\Trait\Controller\WebController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/setting/brand',
    name: 'admin.setting.brand.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class BrandController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index    = 'admin.setting.brand.index';

    /** @description link to the create page */
    private static string $create   = 'admin.setting.brand.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.setting.brand.delete';

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, SettingBrandRepository $repository): Response
    {
        // Variables
        $home  = $this->translator->trans('text.setting');
        $title = $this->translator->trans('text.all.brands');

        return $this->render('@App/contents/back/setting/brand.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::Breadcrump($home, $title),
            'links'           => self::LinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        // Variables
        $home  = $this->translator->trans('text.setting');
        $page  = $this->translator->trans('text.brand');
        $title = $this->translator->trans('text.create.brand');
        $entity = new SettingBrand();
        $form = $this->createForm(SettingBrandType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            // Flash Message
//            $this->addFlash('success', [
//                'title' => $page,
//                'message' => sprintf($this->translator->trans('notification.created'), $entity->getSlug())
//            ]);
            $this->addFlash('success', sprintf($this->translator->trans('notification.created'), $entity->getSlug()));

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::Breadcrump($home, $page),
            'links'           => self::LinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entity,
            'form'            => $form,
        ]);
    }

    #[Route('/update.php/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingBrand $entities, EntityManagerInterface $manager): Response
    {
        // Variables
        $home  = $this->translator->trans('text.setting');
        $page  = $this->translator->trans('text.brand');
        $title = $entities->getName();
        $form  = $this->createForm(SettingBrandType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.brand'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getName())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::Breadcrump($home, $page),
            'links'           => self::LinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, SettingBrand $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.brand'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getName())
            ]);
        }

        return $this->redirectToIndex();
    }
}
