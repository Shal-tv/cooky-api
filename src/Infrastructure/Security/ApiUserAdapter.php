<?php

declare(strict_types = 1);

namespace App\Infrastructure\Security;

use App\Domain\Model\ApiUser;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class ApiUserAdapter implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(private ApiUser $apiUser)
    {
    }

    public function getApiUser(): ApiUser
    {
        return $this->apiUser;
    }

    /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        $email = $this->apiUser->getEmail();

        if ('' === $email) {
            throw new \LogicException('The user email cannot be empty.');
        }

        return $email;
    }

    /**
     * @return list<string>
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->apiUser->getRoles();
    }

    public function getPassword(): string
    {
        return $this->apiUser->getPassword();
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
    }
}
