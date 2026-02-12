<?php

declare(strict_types=1);

namespace App\Service\Command\Extractor\Garage;

use App\Interface\ExtractorServiceInterface;
use App\Service\Command\ExtractorService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;

class EventWeeklyService implements ExtractorServiceInterface
{
    use ExtractorService;

    private static string $folder = 'garage';

    private static string $file = 'event-weekly.yaml';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SerializerInterface    $serializer,
    )
    {}

    public function extractDatas(): string
    {
        // TODO: Implement extractDatas() method.
    }
}
