<?php

declare(strict_types=1);

namespace App\Application\Controller\Back\Setting;

use App\Application\Service\Controller\WebController;
use App\Domain\Entity\SettingClass;
use App\Domain\Form\Back\SettingClassType;
use App\Domain\Repository\SettingClassRepository;
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

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'admin.setting.class.index',
      'create' => 'admin.setting.class.create',
      'read'   => null,
      'update' => 'admin.setting.class.update',
      'delete' => 'admin.setting.class.delete',
    ];

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, SettingClassRepository $repository): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.setting');
        $title = $this->translator->trans('text.all.classes');

        return $this->render('@App/theme-aero/contents/back/setting/class.html.twig', [
            'container'         => 'container-fluid',
            'breadcrumb'        => self::Breadcrumb($home, $title),
            'links'             => self::$crud,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $repository->findAll(),
            'theme'             => 'dark',
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.setting');
        $page   = $this->translator->trans('text.class');
        $title  = $this->translator->trans('text.create.class');
        $entity = new SettingClass();
        $form   = $this->createForm(SettingClassType::class, $entity)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'success',
                message: sprintf($this->translator->trans('notification.created'), $entity->getLabel() . ' ' . $entity->getValue())
            );

            return $this->redirectToIndex();
        }

        return $this->render('@App/theme-aero/contents/back/common-form.html.twig', [
            'container'         => 'container-fluid',
            'breadcrumb'        => self::Breadcrumb($home, $page),
            'links'             => self::$crud,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $entity,
            'form'              => $form,
            'theme'             => 'dark',
        ]);
    }

    #[Route('/update.php/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingClass $entities, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.setting');
        $page  = $this->translator->trans('text.class');
        $title = $entities->getLabel() . ' ' . $entities->getValue();
        $form  = $this->createForm(SettingClassType::class, $entities)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'info',
                message: sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getLabel() . ' ' . $entities->getValue())
            );

            return $this->redirectToIndex();
        }

        return $this->render('@App/theme-aero/contents/back/common-form.html.twig', [
            'container'         => 'container-fluid',
            'breadcrumb'        => self::Breadcrumb($home, $page),
            'links'             => self::$crud,
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'entities'          => $entities,
            'form'              => $form,
            'theme'             => 'dark',
        ]);
    }

    #[Route('/delete.php/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, SettingClass $entities, EntityManagerInterface $manager): Response
    {
        ### Forms
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'error',
                message: sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getLabel() . ' ' . $entities->getValue())
            );
        }

        return $this->redirectToIndex();
    }
}
