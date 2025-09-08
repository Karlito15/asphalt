<?php

namespace App\Controller\Web\Settings;

use App\Entity\SettingUnitPrice;
use App\Form\Settings\UnitPriceType;
use App\Repository\SettingUnitPriceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/setting/unit-price', name: 'admin.setting.unitprice.', options: ['expose' => true], format: 'html', utf8: true)]
final class UnitPriceController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(SettingUnitPriceRepository $repository): Response
    {
        $title = $this->translator->trans('controllerName.admin.unitprice.index');

        return $this->render('@App/admin/settings/unit-price/index.html.twig', [
            'controller_name'     => $title,
            'breadcrumb'          => ['lvl1' => 'Race', 'lvl2' => $title],
            'index'               => 'admin.setting.unitprice.index',
            'create'              => 'admin.setting.unitprice.create',
            'unit_prices'         => $repository->getDatas(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $settingUnitPrice = new SettingUnitPrice();
        $form = $this->createForm(UnitPriceType::class, $settingUnitPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($settingUnitPrice);
            $entityManager->flush();

            return $this->redirectToRoute('admin.setting.unitprice.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.unitprice.create');

        return $this->render('@App/admin/settings/unit-price/form.html.twig', [
            'controller_name'    => $title,
            'breadcrumb'         => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'              => 'admin.setting.unitprice.index',
            'current'            => $request->attributes->get('_route'),
            'setting_unit_price' => $settingUnitPrice,
            'form'               => $form,
        ]);
    }

    #[Route('/update/{slug}-{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS, 'slug' => Requirement::ASCII_SLUG], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingUnitPrice $settingUnitPrice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UnitPriceType::class, $settingUnitPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin.setting.unitprice.index', [], Response::HTTP_SEE_OTHER);
        }

        $title = $this->translator->trans('controllerName.admin.unitprice.update');

        return $this->render('@App/admin/settings/unit-price/form.html.twig', [
            'controller_name'    => $title,
            'breadcrumb'         => ['lvl1' => 'Setting', 'lvl2' => $title],
            'index'              => 'admin.setting.unitprice.index',
            'current'            => $request->attributes->get('_route'),
            'setting_unit_price' => $settingUnitPrice,
            'form'               => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SettingUnitPrice $settingUnitPrice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$settingUnitPrice->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($settingUnitPrice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.setting.unitprice.index', [], Response::HTTP_SEE_OTHER);
    }
}
