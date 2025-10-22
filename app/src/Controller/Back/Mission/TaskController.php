<?php

namespace App\Controller\Back\Mission;

use App\Entity\MissionTask;
use App\Form\Back\MissionTaskType;
use App\Repository\MissionTaskRepository;
use App\Trait\Controller\WebTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/mission/task', name: 'admin.mission.task.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class TaskController extends AbstractController
{
    use WebTrait;

    /** @description link to the index page */
    private static string $index    = 'admin.mission.task.index';

    /** @description link to the create page */
    private static string $create   = 'admin.mission.task.create';

    /** @description link to the delete page */
    private static string $delete   = 'admin.mission.task.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, MissionTaskRepository $repository): Response
    {
        $title = $this->translator->trans('text.all.tasks');

        return $this->render('@App/back/contents/mission/common.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.back-office'), 'level2' => $title],
            'links'           => ['index' => self::$index, 'create' => self::$create, 'update' => 'admin.mission.task.update'],
            'entities'        => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $title    = $this->translator->trans('text.create.task');
        $entities = new MissionTask();
        $form     = $this->createForm(MissionTaskType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('success', [
                'title' => $this->translator->trans('text.task'),
                'message' => sprintf($this->translator->trans('notification.created'), $entities->getId(), $entities->getValue())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.task'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, MissionTask $entities, EntityManagerInterface $manager): Response
    {
        $title = $entities->getValue();
        $form  = $this->createForm(MissionTaskType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            // Flash Message
            $this->addFlash('info', [
                'title' => $this->translator->trans('text.task'),
                'message' => sprintf($this->translator->trans('notification.updated'), $entities->getId(), $entities->getValue())
            ]);

            return $this->redirectToIndex();
        }

        return $this->render('@App/back/contents/common/form.html.twig', [
            'controller_name' => $title,
            'current_page'    => $request->attributes->get('_route'),
            'container'       => 'container',
            'breadcrumb'      => ['level1' => $this->translator->trans('text.task'), 'level2' => $title],
            'links'           => self::getLinksPage(),
            'entities'        => $entities,
            'form'            => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, MissionTask $entities, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $manager->remove($entities);
            $manager->flush();

            // Flash Message
            $this->addFlash('error', [
                'title' => $this->translator->trans('text.task'),
                'message' => sprintf($this->translator->trans('notification.deleted'), $entities->getId(), $entities->getValue())
            ]);
        }

        return $this->redirectToIndex();
    }
}
