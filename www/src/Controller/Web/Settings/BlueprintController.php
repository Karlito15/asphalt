<?php

namespace App\Controller\Web\Settings;

use App\Entity\SettingBlueprint;
use App\Form\Settings\BlueprintType;
use App\Repository\SettingBlueprintRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/setting/blueprint', name: 'admin.setting.blueprint.', options: ['expose' => true], format: 'html', utf8: true)]
final class BlueprintController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(SettingBlueprintRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.blueprint.index');

        return $this->render('@App/admin/settings/blueprint/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'           => 'admin.setting.blueprint.index',
            'create'          => 'admin.setting.blueprint.create',
            'blueprints'      => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $settingBlueprint = new SettingBlueprint();
        $form = $this->createForm(BlueprintType::class, $settingBlueprint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($settingBlueprint);
            $entityManager->flush();

            return $this->redirectToRoute('admin.setting.blueprint.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.blueprint.create');

        return $this->render('@App/admin/settings/blueprint/form.html.twig', [
            'controller_name'   => $title,
            'breadcrumb'        => ['lvl1' => 'Setting', 'lvl2' => $title],
            'current'           => $request->attributes->get('_route'),
            'index'             => 'admin.setting.blueprint.index',
            'setting_blueprint' => $settingBlueprint,
            'form'              => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingBlueprint $settingBlueprint, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlueprintType::class, $settingBlueprint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.setting.blueprint.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.blueprint.update');

        return $this->render('@App/admin/settings/blueprint/form.html.twig', [
            'controller_name'   => $title,
            'breadcrumb'        => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'             => 'admin.setting.blueprint.index',
            'current'           => $request->attributes->get('_route'),
            'setting_blueprint' => $settingBlueprint,
            'form'              => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SettingBlueprint $settingBlueprint, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingBlueprint->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingBlueprint);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.setting.blueprint.index', [], Response::HTTP_SEE_OTHER);
    }
}
