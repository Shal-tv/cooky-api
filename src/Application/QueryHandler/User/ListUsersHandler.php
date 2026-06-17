<?php

declare(strict_types = 1);

namespace App\Application\QueryHandler\User;

use App\Application\Query\User\ListUsers;
use App\Domain\Model\ApiUser;
use App\Domain\Repository\ApiUserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ListUsersHandler
{
    public function __construct(private ApiUserRepositoryInterface $apiUserRepository)
    {
    }

    /**
     * @return list<ApiUser>
     */
    public function __invoke(ListUsers $listUsers): array
    {
        return $this->apiUserRepository->findAll();
    }
}
