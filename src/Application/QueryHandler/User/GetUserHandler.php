<?php

declare(strict_types = 1);

namespace App\Application\QueryHandler\User;

use App\Application\Query\User\GetUser;
use App\Domain\Model\ApiUser;
use App\Domain\Repository\ApiUserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetUserHandler
{
    public function __construct(private ApiUserRepositoryInterface $apiUserRepository)
    {
    }

    public function __invoke(GetUser $getUser): ApiUser
    {
        return $this->apiUserRepository->find($getUser->getUuid());
    }
}
