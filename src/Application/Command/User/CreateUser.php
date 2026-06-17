<?php

declare(strict_types = 1);

namespace App\Application\Command\User;

use App\Application\Command\CommandInterface;
use App\Domain\Model\ApiUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints;

#[UniqueEntity(
    fields: 'username',
    entityClass: ApiUser::class
)]
#[UniqueEntity(
    fields: 'email',
    entityClass: ApiUser::class
)]
final readonly class CreateUser implements CommandInterface
{
    #[Constraints\Type('string')]
    #[Constraints\Length(min: 6)]
    private string $username;

    #[Constraints\Type('string')]
    #[Constraints\NotBlank]
    #[Constraints\Email]
    private string $email;

    #[Constraints\Type('string')]
    #[Constraints\NotBlank]
    #[Constraints\PasswordStrength]
    private string $password;

    public function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
