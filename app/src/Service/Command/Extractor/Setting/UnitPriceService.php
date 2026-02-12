<?php

declare(strict_types=1);

namespace App\Service\Command\Extractor\Setting;

use App\Interface\ExtractorServiceInterface;
use App\Persistence\Entity\SettingUnitPrice;
use App\Service\Command\ExtractorService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UnitPriceService implements ExtractorServiceInterface
{
    use ExtractorService;

    private static string $folder = 'setting';

    private static string $file = 'unit-price.yaml';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SerializerInterface    $serializer,
    )
    {}

    public function extractDatas(): string
    {
        try {
            $em = $this->entityManager;
            $datas = $em->getRepository(SettingUnitPrice::class)->findAll();
            $json = $this->serializer->serialize($datas, 'json', [
                'groups' => ['index']
            ]);
            $em->clear();

            return $json;
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        return '';
    }
}
