<?php

namespace App\Controller\Web\Settings;

use App\Entity\SettingLevel;
use App\Form\Settings\LevelType;
use App\Repository\SettingLevelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/setting/level', name: 'admin.setting.level.', options: ['expose' => true], format: 'html', utf8: true)]
final class LevelController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(SettingLevelRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.level.index');

        return $this->render('@App/admin/settings/level/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.setting.level.index',
            'create'          => 'admin.setting.level.create',
            'levels'          => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $settingLevel = new SettingLevel();
        $form = $this->createForm(LevelType::class, $settingLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($settingLevel);
            $entityManager->flush();

            return $this->redirectToRoute('admin.setting.level.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.level.create');

        return $this->render('@App/admin/settings/level/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'           => 'admin.setting.level.index',
            'current'         => $request->attributes->get('_route'),
            'setting_level'   => $settingLevel,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingLevel $settingLevel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LevelType::class, $settingLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.setting.level.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.level.update');

        return $this->render('@App/admin/settings/level/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'           => 'admin.setting.level.index',
            'current'         => $request->attributes->get('_route'),
            'setting_level'   => $settingLevel,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SettingLevel $settingLevel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingLevel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingLevel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.setting.level.index', [], Response::HTTP_SEE_OTHER);
    }
}
