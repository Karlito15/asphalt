<?php

namespace App\Controller\Back\Setting;

use App\Entity\SettingTag;
use App\Form\Back\SettingTagType;
use App\Repository\SettingTagRepository;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/setting/tag', name: 'admin.setting.tag.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class TagController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index    = 'admin.setting.tag.index';

    /** @description link to the create page */
    private static string $create   = 'admin.setting.tag.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.setting.tag.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, SettingTagRepository $repository): Response
    {
        $title = $this->translator->trans('text.all.tags');

        return $this->render('@App/back/contents/setting/tag.html.twig', [
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
        $title = $this->translator->trans('text.create.tag');
        $entities = new SettingTag();
        $form = $this->createForm(SettingTagType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $this->translator->trans('text.tag'),
                'message' => sprintf($this->translator->trans('notification.created'), $entities->getId(), $entities->getValue())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => $this->translator->trans('text.tag'), 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
     }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingTag $entities, EntityManagerInterface $manager): Response
    {
        $title = $entities->getValue();
        $form = $this->createForm(SettingTagType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.tag'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getValue())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => $this->translator->trans('text.tag'), 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, SettingTag $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.tag'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getValue())
            ]);
        }

        return $this->redirectToIndex();
    }
}
