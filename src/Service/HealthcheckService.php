<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Throwable;

/**
 * Class HealthcheckService
 *
 * @package App\Service
 */
final readonly class HealthcheckService
{

    /**
     * HealthcheckService Constructor.
     *
     * @param EntityManagerInterface  $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @return bool
     */
    public function checkDBConnection(): bool
    {
        if (null === $this->entityManager) {
            return false;
        }

        try {
            $this->entityManager->getConnection()->executeQuery('SELECT 1');
        } catch (Throwable $e) {
            return false;
        }

        return true;
    }

}
