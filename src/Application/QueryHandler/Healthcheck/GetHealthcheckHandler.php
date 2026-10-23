<?php

declare(strict_types=1);

namespace App\Application\QueryHandler\Healthcheck;

use App\Application\Query\Healthcheck\GetHealthcheck;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetHealthcheckHandler
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    /**
     * @return array{readwriteConnection: bool}
     */
    public function __invoke(GetHealthcheck $getHealthcheck): array
    {
        return [
            'readwriteConnection' => $this->checkDBConnection($this->em),
        ];
    }

    private function checkDBConnection(?EntityManagerInterface $manager): bool
    {
        if (null === $manager) {
            return false;
        }

        try {
            $manager->getConnection()->executeQuery('SELECT 1');

            return $manager->getConnection()->isConnected();
        } catch (\Throwable $e) {
            return false;
        }
    }
}
