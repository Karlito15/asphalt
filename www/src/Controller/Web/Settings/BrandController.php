<?php

namespace App\Controller\Web\Settings;

use App\Entity\SettingBrand;
use App\Form\Settings\BrandType;
use App\Repository\SettingBrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/setting/brand', name: 'admin.setting.brand.', options: ['expose' => true], format: 'html', utf8: true)]
final class BrandController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(SettingBrandRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.brand.index');

        return $this->render('@App/admin/settings/brand/index.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'           => 'admin.setting.brand.index',
            'create'          => 'admin.setting.brand.create',
            'brands'          => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $settingBrand = new SettingBrand();
        $form = $this->createForm(BrandType::class, $settingBrand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($settingBrand);
            $entityManager->flush();

            return $this->redirectToRoute('admin.setting.brand.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.brand.create');

        return $this->render('@App/admin/settings/brand/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'           => 'admin.setting.brand.index',
            'current'         => $request->attributes->get('_route'),
            'setting_brand'   => $settingBrand,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingBrand $settingBrand, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrandType::class, $settingBrand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.setting.brand.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.brand.update');

        return $this->render('@App/admin/settings/brand/form.html.twig', [
            'controller_name' => $title,
            'breadcrumb'      => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'           => 'admin.setting.brand.index',
            'current'         => $request->attributes->get('_route'),
            'setting_brand'   => $settingBrand,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SettingBrand $settingBrand, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingBrand->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingBrand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.setting.brand.index', [], Response::HTTP_SEE_OTHER);
    }
}
