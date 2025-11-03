<?php

namespace App\Controller\Back\Mission;

use App\Entity\MissionType;
use App\Form\Back\MissionTypeType;
use App\Repository\MissionTypeRepository;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/mission/type', name: 'admin.mission.type.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class TypeController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index    = 'admin.mission.type.index';

    /** @description link to the create page */
    private static string $create   = 'admin.mission.type.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.mission.type.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, MissionTypeRepository $repository): Response
    {
        $title = $this->translator->trans('text.all.types');

        return $this->render('@App/back/contents/mission/common.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.back-office'), 'level2' => $title],
            'links'           => ['index' => self::$index, 'create' => self::$create, 'update' => 'admin.mission.type.update'],
            'entities'        => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $title = $this->translator->trans('text.create.type');
        $entities = new MissionType();
        $form = $this->createForm(MissionTypeType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $this->translator->trans('text.type'),
                'message' => sprintf($this->translator->trans('notification.created'), $entities->getId(), $entities->getValue())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.type'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, MissionType $entities, EntityManagerInterface $manager): Response
    {
        $title = $entities->getValue();
        $form  = $this->createForm(MissionTypeType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.type'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getValue())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.type'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}.php', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, MissionType $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.type'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getValue())
            ]);
        }

        return $this->redirectToIndex();
    }
}
