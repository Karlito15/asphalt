<?php

namespace App\Controller\Web\Back\Mission;

use App\Able\Controller\WebAble;
use App\Entity\MissionType;
use App\Form\Back\MissionTypeType;
use App\Repository\MissionTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('{_locale<%app.supported_locales%>}/admin/mission/type', name: 'app.mission.type.', options: ['expose' => false], schemes: ['http', 'https'], format: 'html', utf8: true)]
final class TypeController extends AbstractController
{
    use WebAble;

    /** @description link to the index page */
    private static string $index    = 'app.mission.type.index';

    /** @description link to the create page */
    private static string $create   = 'app.mission.type.create';

    /** @description link to the delete page */
    private static string $delete   = 'app.mission.type.delete';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/index.php', name: 'index', methods: ['GET'])]
    public function index(Request $request, MissionTypeRepository $repository): Response
    {
        $title = $this->translator->trans('app.mission.type.index.title');

        return $this->render('@App/contents/back/mission.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'Type', 'level2' => $title],
            'links'             => ['index' => self::$index, 'create' => self::$create, 'update' => 'app.mission.type.update'],
            'entities'          => $repository->findAll(),
        ]);
    }

    #[Route('/create.php', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $title = $this->translator->trans('app.mission.type.create.title');
        $entities = new MissionType();
        $form = $this->createForm(MissionTypeType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entities);
            $entityManager->flush();

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/back/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'Type', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/update/{id}.php', name: 'update', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function update(Request $request, MissionType $entities, EntityManagerInterface $entityManager): Response
    {
        $title = $this->translator->trans('app.mission.type.update.title') . ' ' . $entities->getValue();
        $form  = $this->createForm(MissionTypeType::class, $entities)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@App/contents/back/common/form.html.twig', [
            'controller_name'   => $title,
            'current_page'      => $request->attributes->get('_route'),
            'breadcrumb'        => ['level1' => 'Type', 'level2' => $title],
            'links'             => self::getLinksPage(),
            'entities'          => $entities,
            'form'              => $form,
        ]);
    }

    #[Route('/delete/{id}.php', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['POST'])]
    public function delete(Request $request, MissionType $entities, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entities->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($entities);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
    }
}
