<?php

declare(strict_types = 1);

namespace App\Application\CommandHandler\User;

use App\Application\Command\User\DeleteUser;
use App\Domain\Repository\ApiUserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteUserHandler
{
    public function __construct(private ApiUserRepositoryInterface $apiUserRepository)
    {
    }

    public function __invoke(DeleteUser $deleteUser): null
    {
        $user = $this->apiUserRepository->find($deleteUser->getUuid());

        $this->apiUserRepository->delete($user);

        return null;
    }
}
