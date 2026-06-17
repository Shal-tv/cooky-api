<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

final class ArchiveFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, string $targetTableAlias): string
    {
        return $targetTableAlias . '.archive = false';
    }
}
