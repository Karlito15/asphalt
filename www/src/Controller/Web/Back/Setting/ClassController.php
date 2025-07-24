<?php

namespace App\Controller\Web\Back\Setting;

use App\Able\Controller\WebAble;
use App\Entity\SettingClass;
use App\Form\Back\SettingClassType;
use App\Repository\SettingClassRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/setting/class', name: 'app.setting.class.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
//#[Route('/admin/setting/class', name: 'app.setting.class.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class ClassController extends AbstractController
{
    use WebAble;

    /** @description link to the index page */
    private static string $index    = 'app.setting.class.index';

    /** @description link to the create page */
    private static string $create   = 'app.setting.class.create';

    /** @description link to the delete page */
    private static string $delete   = 'app.setting.class.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, SettingClassRepository $repository): Response
    {
        $title = $this->translator->trans('app.setting.class.index.title');

        return $this->render('@App/contents/back/setting/class.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'Class', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $title    = $this->translator->trans('app.setting.class.create.title');
        $entities = new SettingClass();
        $form     = $this->createForm(SettingClassType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entities);
            $entityManager->flush();

            // Flash
            $this->addFlash('success', $this->translator->trans('app.flash.common.create'));

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/back/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'Class', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingClass $entities, EntityManagerInterface $entityManager): Response
    {
        $title = $this->translator->trans('app.setting.class.update.title');
        $form  = $this->createForm(SettingClassType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Flash
            $this->addFlash('success', $this->translator->trans('app.flash.common.update'));

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/back/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'Class', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, SettingClass $entities, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($entities);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
    }
}
