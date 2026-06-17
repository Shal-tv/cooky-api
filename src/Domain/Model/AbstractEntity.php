<?php

declare(strict_types = 1);

namespace App\Domain\Model;

use DateTimeImmutable;

abstract class AbstractEntity
{
    private string $uuid;

    private DateTimeImmutable $dateCreated;

    private bool $archive = false;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
        $this->dateCreated = new DateTimeImmutable();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getDateCreated(): DateTimeImmutable
    {
        return $this->dateCreated;
    }

    public function isArchive(): bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }
}
