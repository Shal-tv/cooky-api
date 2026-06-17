<?php

declare(strict_types = 1);

namespace App\Application\CommandHandler\User;

use App\Application\Command\User\CreateUser;
use App\Domain\Model\ApiUser;
use App\Domain\Repository\ApiUserRepositoryInterface;
use App\Infrastructure\Security\ApiUserAdapter;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

#[AsMessageHandler]
final readonly class CreateUserHandler
{
    public function __construct(
        private UuidFactory $uuidFactory,
        private ApiUserRepositoryInterface $apiUserRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function __invoke(CreateUser $createUser): ApiUser
    {
        $user = new ApiUser($this->uuidFactory->create()->toString());

        $user->setUsername($createUser->getUsername());
        $user->setEmail($createUser->getEmail());

        $hashedPassword = $this->passwordHasher->hashPassword(
            new ApiUserAdapter($user),
            $createUser->getPassword()
        );

        $user->setPassword($hashedPassword);

        $this->apiUserRepository->add($user);

        return $user;
    }
}
