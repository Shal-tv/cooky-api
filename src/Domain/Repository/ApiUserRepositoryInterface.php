<?php

declare(strict_types = 1);

namespace App\Domain\Repository;

use App\Domain\Model\ApiUser;

interface ApiUserRepositoryInterface
{
    /**
     * @return list<ApiUser>
     */
    public function findAll(): array;

    public function find(mixed $id): ApiUser;

    public function findOneByEmail(string $email): ?ApiUser;

    public function add(ApiUser $user): void;

    public function update(ApiUser $user): void;

    public function delete(ApiUser $user): void;
}
