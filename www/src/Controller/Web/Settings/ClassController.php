<?php

namespace App\Controller\Web\Settings;

use App\Entity\SettingClass;
use App\Form\Settings\ClassType;
use App\Repository\SettingClassRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/setting/class', name: 'admin.setting.class.', options: ['expose' => true], format: 'html', utf8: true)]
final class ClassController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(SettingClassRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.class.index');

        return $this->render('@App/admin/settings/class/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.setting.class.index',
            'create'          => 'admin.setting.class.create',
            'settingClasses'  => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $settingClass = new SettingClass();
        $form = $this->createForm(ClassType::class, $settingClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($settingClass);
            $entityManager->flush();

            return $this->redirectToRoute('admin.setting.class.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.class.create');

        return $this->render('@App/admin/settings/class/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'           => 'admin.setting.class.index',
            'current'         => $request->attributes->get('_route'),
            'setting_class'   => $settingClass,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingClass $settingClass, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClassType::class, $settingClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.setting.class.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.class.update');

        return $this->render('@App/admin/settings/class/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'           => 'admin.setting.class.index',
            'current'         => $request->attributes->get('_route'),
            'setting_class'   => $settingClass,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SettingClass $settingClass, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingClass->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingClass);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.setting.class.index', [], Response::HTTP_SEE_OTHER);
    }
}
