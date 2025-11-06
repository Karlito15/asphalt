<?php

declare(strict_types=1);

namespace App\Service\Cache;

use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Loggable\Entity\LogEntry;

class LogService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * @param $entity
     * @return array[LogEntry]
     */
    public function getLogs($entity): array
    {
        $logs = $this->getLog($entity);
        $key  = $this->getKey($logs);
        $id   = $this->getId($logs, $key);

        return $this->entityManager->getRepository(LogEntry::class)->findBy(['objectId' => $id]);
    }

    /**
     * @param $entity
     * @return array[LogEntry]
     */
    private function getLog($entity): array
    {
        return $this->entityManager->getRepository(LogEntry::class)->getLogEntries($entity);
    }

    /**
     * @param array $logs
     * @return int
     */
    private function getKey(array $logs): int
    {
        return array_key_first($logs);
    }

    /**
     * @param array $log
     * @param int $key
     * @return int
     */
    private function getId(array $log, int $key): int
    {
        return (int) $log[$key]->getObjectId();
    }
}
