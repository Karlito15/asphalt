<?php

declare(strict_types=1);

namespace App\Controller\Back\Setting;

use App\Persistence\Entity\SettingClass;
use App\Persistence\Form\Back\SettingClassType;
use App\Persistence\Repository\SettingClassRepository;
use App\Toolbox\Trait\Controller\WebController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route(
    path: '{_locale<%app.supported_locales%>}/admin/setting/class',
    name: 'admin.setting.class.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'html',
    utf8: true
)]
final class ClassController extends AbstractController
{
    use WebController;

    /** @description link to the index page */
    private static string $index    = 'admin.setting.class.index';

    /** @description link to the create page */
    private static string $create   = 'admin.setting.class.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.setting.class.delete';

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, SettingClassRepository $repository): Response
    {
        // Variables
        $home  = $this->translator->trans('text.setting');
        $title = $this->translator->trans('text.all.classes');

        return $this->render('@App/contents/back/setting/class.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::getBreadcrump($home, $title),
            'links'           => self::getLinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $repository->findAll(),
            'setting_classes' => $repository->findAll(),
        ]);
    }

     #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        // Variables
        $home  = $this->translator->trans('text.setting');
        $page  = $this->translator->trans('text.class');
        $title = $this->translator->trans('text.create.class');
        $entity = new SettingClass();
        $form = $this->createForm(SettingClassType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $page,
                'message' => sprintf($this->translator->trans('notification.created'), $entity->getSlug())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::getBreadcrump($home, $page),
            'links'           => self::getLinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entity,
            'form'            => $form,
        ]);
    }

    #[Route('/update.php/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingClass $entities, EntityManagerInterface $manager): Response
    {
        // Variables
        $home  = $this->translator->trans('text.setting');
        $page  = $this->translator->trans('text.class');
        $title = $entities->getLabel() . ' ' . $entities->getValue();
        $form  = $this->createForm(SettingClassType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.class'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getLabel() . ' ' . $entities->getValue())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'breadcrumb'      => self::getBreadcrump($home, $page),
            'links'           => self::getLinksPage(),
            'container'       => 'container-fluid',
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, SettingClass $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.class'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getLabel() . ' ' . $entities->getValue())
            ]);
        }

        return $this->redirectToIndex();
    }
}
