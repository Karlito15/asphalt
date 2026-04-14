<?php

declare(strict_types=1);

namespace App\Application\Controller\Back\Setting;

use App\Application\Service\Controller\WebController;
use App\Domain\Entity\SettingBrand;
use App\Domain\Form\Back\SettingBrandType;
use App\Domain\Repository\SettingBrandRepository;
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

    /** @description link to pages */
    private static array $crud = [
      'index'  => 'admin.setting.brand.index',
      'create' => 'admin.setting.brand.create',
      'read'   => null,
      'update' => 'admin.setting.brand.update',
      'delete' => 'admin.setting.brand.delete',
    ];

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, SettingBrandRepository $repository): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.setting');
        $title = $this->translator->trans('text.all.brands');

        return $this->render('@App/contents/back/setting/brand.html.twig', [
            'container'       => 'container-fluid',
            'breadcrumb'      => self::Breadcrumb($home, $title),
            'links'           => self::$crud,
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home   = $this->translator->trans('text.setting');
        $page   = $this->translator->trans('text.brand');
        $title  = $this->translator->trans('text.create.brand');
        $entity = new SettingBrand();
        $form   = $this->createForm(SettingBrandType::class, $entity)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'success',
                message: sprintf($this->translator->trans('notification.created'), $entity->getName())
            );

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/common-form.html.twig', [
            'container'       => 'container-fluid',
            'breadcrumb'      => self::Breadcrumb($home, $page),
            'links'           => self::$crud,
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $entity,
            'form'            => $form,
        ]);
    }

    #[Route('/update.php/{id}', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingBrand $entities, EntityManagerInterface $manager): Response
    {
        ### Variables
        $home  = $this->translator->trans('text.setting');
        $page  = $this->translator->trans('text.brand');
        $title = $entities->getName();
        $form  = $this->createForm(SettingBrandType::class, $entities)->handleRequest($request);

        ### Forms
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'info',
                message: sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getName())
            );

            return $this->redirectToIndex();
        }

        return $this->render('@App/contents/back/common-form.html.twig', [
            'container'       => 'container-fluid',
            'breadcrumb'      => self::Breadcrumb($home, $page),
            'links'           => self::$crud,
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete.php/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, SettingBrand $entities, EntityManagerInterface $manager): Response
    {
        ### Forms
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            ### Flash Message
            $this->addFlash(
                type:'error',
                message: sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getName())
            );
        }

        return $this->redirectToIndex();
    }
}
