<?php

declare(strict_types=1);

namespace App\Application\Controller\API\Setting;

use App\Domain\Entity\SettingBlueprint;
use App\Domain\Repository\SettingBlueprintRepository;
use App\Infrastructure\Abstract\Controller\AbstractAPIController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(
    path: 'api/setting/blueprint',
    name: 'api.setting.blueprint.',
    options: ['expose' => false],
    schemes: ['http', 'https'],
    format: 'json',
    utf8: true
)]
final class BlueprintController extends AbstractAPIController
{
    #[Route(path: '/index', name: 'index', methods: ['GET'])]
    public function index(SettingBlueprintRepository $repository): JsonResponse
    {
        return $this->json(
            $repository->findAll(),
            Response::HTTP_OK,
            self::getHeaders(),
            self::getContext([
                'groups' => ['index'],
            ])
        );
    }

    #[Route(path: '/{id}', name: 'detail', methods: ['GET'])]
    public function detail(
        int $id,
        SettingBlueprintRepository $repository
    ): JsonResponse
    {
        return $this->json(
            $repository->findOneBy(['id' => $id]),
            Response::HTTP_OK,
            self::getHeaders(),
            self::getContext([
                'groups' => ['detail'],
            ])
        );
    }

    /**
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @param UrlGeneratorInterface $urlGenerator
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    #[Route(path: '/create', name: 'create', methods: ['POST'])]
    public function create(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $manager,
        UrlGeneratorInterface $urlGenerator,
    ): JsonResponse
    {
        ### Récupère les données
        $post = $serializer->deserialize($request->getContent(), SettingBlueprint::class, 'json');

        ### Enregistre les données
        $manager->persist($post);
        $manager->flush();
        $manager->clear();

        return new JsonResponse(
            $serializer->serialize($post, 'json', ['groups' => 'edit']),
            JsonResponse::HTTP_CREATED,
            ['location' => $urlGenerator->generate('api.setting.blueprint.detail', ['id' => $post->getId()])],
            true
        );
    }

    /**
     * @param SettingBlueprint $entity
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    #[Route(path: '/{id}', name: 'put', methods: ['PUT'])]
    public function put(
        SettingBlueprint $entity,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $manager,
    ): JsonResponse
    {
        ### Récupère les données
        $serializer->deserialize($request->getContent(), SettingBlueprint::class, 'json', [
            AbstractNormalizer::OBJECT_TO_POPULATE => $entity
        ]);

        ### Enregistre les données
        $manager->flush();
        $manager->clear();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }

    /**
     * @param SettingBlueprint $entity
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     */
    #[Route(path: '/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(
        SettingBlueprint $entity,
        EntityManagerInterface $manager,
    ): JsonResponse
    {
        $manager->remove($entity);
        $manager->flush();
        $manager->clear();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}
