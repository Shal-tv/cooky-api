<?php

declare(strict_types = 1);

namespace App\Application\CommandHandler\User;

use App\Application\Command\User\UpdateUser;
use App\Domain\Model\ApiUser;
use App\Domain\Repository\ApiUserRepositoryInterface;
use App\Infrastructure\Security\ApiUserAdapter;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
final readonly class UpdateUserHandler
{
    public function __construct(
        private ApiUserRepositoryInterface $apiUserRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function __invoke(UpdateUser $updateUser): ApiUser
    {
        $user = $this->apiUserRepository->find($updateUser->getUuid());

        if (null !== $updateUser->getUsername()) {
            $user->setUsername($updateUser->getUsername());
        }

        if (null !== $updateUser->getEmail()) {
            $user->setEmail($updateUser->getEmail());
        }

        if (null !== $updateUser->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                new ApiUserAdapter($user),
                $updateUser->getPassword()
            );

            $user->setPassword($hashedPassword);
        }

        $this->apiUserRepository->update($user);

        return $user;
    }
}
