<?php

declare(strict_types = 1);

namespace App\Application\Command\User;

use App\Application\Command\CommandInterface;
use App\Domain\Model\ApiUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints;

#[UniqueEntity(
    fields: 'username',
    entityClass: ApiUser::class
)]
#[UniqueEntity(
    fields: 'email',
    entityClass: ApiUser::class
)]
final class UpdateUser implements CommandInterface
{
    #[Constraints\Uuid]
    private Uuid $uuid;

    #[Constraints\Type([
        'string',
        'null'
    ])]
    #[Constraints\Length(min: 6)]
    private ?string $username;

    #[Constraints\Type([
        'string',
        'null'
    ])]
    #[Constraints\Email]
    private ?string $email;

    #[Constraints\Type([
        'string',
        'null'
    ])]
    #[Constraints\PasswordStrength]
    private ?string $password;

    public function __construct(?string $username, ?string $email, ?string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setUuid(Uuid $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
