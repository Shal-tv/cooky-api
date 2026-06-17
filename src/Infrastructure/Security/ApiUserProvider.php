<?php

declare(strict_types = 1);

namespace App\Infrastructure\Security;

use App\Domain\Repository\ApiUserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @implements UserProviderInterface<ApiUserAdapter>
 */
final readonly class ApiUserProvider implements UserProviderInterface
{
    public function __construct(private ApiUserRepositoryInterface $userRepository)
    {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $apiUser = $this->userRepository->findOneByEmail($identifier);

        if (!$apiUser) {
            throw new UserNotFoundException("User with email $identifier not found.");
        }

        return new ApiUserAdapter($apiUser);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof ApiUserAdapter) {
            throw new \InvalidArgumentException('Unexpected user type.');
        }

        $apiUser = $this->userRepository->findOneByEmail($user->getUserIdentifier());

        if (null === $apiUser) {
            throw new UserNotFoundException('User could not be refreshed.');
        }

        return new ApiUserAdapter($apiUser);
    }

    public function supportsClass(string $class): bool
    {
        return ApiUserAdapter::class === $class;
    }
}
