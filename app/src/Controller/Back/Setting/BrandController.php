<?php

namespace App\Controller\Back\Setting;

use App\Entity\SettingBrand;
use App\Form\Back\SettingBrandType;
use App\Repository\SettingBrandRepository;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/setting/brand', name: 'admin.setting.brand.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class BrandController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index    = 'admin.setting.brand.index';

    /** @description link to the create page */
    private static string $create   = 'admin.setting.brand.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.setting.brand.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, SettingBrandRepository $repository): Response
    {
        $title = $this->translator->trans('text.all.brands');

        return $this->render('@App/back/contents/setting/brand.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => $this->translator->trans('text.back-office'), 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $title    = $this->translator->trans('text.create.brand');
        $entities = new SettingBrand();
        $form     = $this->createForm(SettingBrandType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $this->translator->trans('text.brand'),
                'message' => sprintf($this->translator->trans('notification.created'), $entities->getId(), $entities->getName())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => 'Brand', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingBrand $entities, EntityManagerInterface $manager): Response
    {
        $title = $entities->getName();
        $form  = $this->createForm(SettingBrandType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.brand'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getName())
            ]);

            return $this->redirectToRoute('admin.setting.brand.update', ['id' => $entities->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => 'Brand', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
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
            ]);        }

        return $this->redirectToIndex();
    }
}
