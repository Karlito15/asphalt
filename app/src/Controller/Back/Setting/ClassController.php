<?php

namespace App\Controller\Back\Setting;

use App\Entity\SettingClass;
use App\Form\Back\SettingClassType;
use App\Repository\SettingClassRepository;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/setting/class', name: 'admin.setting.class.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class ClassController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index    = 'admin.setting.class.index';

    /** @description link to the create page */
    private static string $create   = 'admin.setting.class.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.setting.class.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, SettingClassRepository $repository): Response
    {
        $title = $this->translator->trans('text.all.classes');

        return $this->render('@App/back/contents/setting/class.html.twig', [
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
        $title    = $this->translator->trans('text.create.class');
        $entities = new SettingClass();
        $form     = $this->createForm(SettingClassType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $this->translator->trans('text.class'),
                'message' => sprintf($this->translator->trans('notification.created'), $entities->getId(), $entities->getLabel() . ' ' . $entities->getValue())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => 'Class', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingClass $entities, EntityManagerInterface $manager): Response
    {
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

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'        => ['level1' => 'Class', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
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
