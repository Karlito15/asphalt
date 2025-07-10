<?php

namespace App\Controller\Web\Back\Setting;

use App\Able\Controller\WebAble;
use App\Entity\SettingBlueprint;
use App\Form\Back\SettingBlueprintType;
use App\Repository\SettingBlueprintRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/setting/blueprint', name: 'app.setting.blueprint.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class BlueprintController extends AbstractController
{
    use WebAble;

    /** @description link to the index page */
    private static string $index = 'app.setting.blueprint.index';

    /** @description link to the create page */
    private static string $create = 'app.setting.blueprint.create';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route(path: '/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, SettingBlueprintRepository $repository): Response
    {
        $title = $this->translator->trans('app.setting.blueprint.index.title');

        return $this->render('@App/contents/back/setting/blueprint/index.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => $title,
            'links'             => self::getLinksPage(),
            'entities'          => $repository->findAll(),
        ]);
    }

    #[Route(path: "/create.php", name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $title    = $this->translator->trans('app.setting.blueprint.create.title');
        $entities = new SettingBlueprint();
        $form     = $this->createForm(SettingBlueprintType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entities);
            $entityManager->flush();

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/back/setting/blueprint/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => $this->translator->trans('app.setting.blueprint.index.title'), 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, SettingBlueprint $entities, EntityManagerInterface $entityManager): Response
    {
        $title = $this->translator->trans('app.setting.blueprint.update.title');
        $form  = $this->createForm(SettingBlueprintType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/back/setting/blueprint/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => $this->translator->trans('app.setting.blueprint.index.title'), 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/delete/{id}.php', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, SettingBlueprint $entities, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($entities);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
    }
}
