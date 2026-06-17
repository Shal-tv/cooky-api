<?php

declare(strict_types = 1);

namespace App\Application\Query\User;

use App\Application\Query\QueryInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints;

final readonly class GetUser implements QueryInterface
{
    #[Constraints\NotBlank]
    #[Constraints\Uuid]
    private Uuid $uuid;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }
}
