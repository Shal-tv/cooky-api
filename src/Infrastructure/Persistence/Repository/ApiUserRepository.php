<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Model\ApiUser;
use App\Domain\Repository\ApiUserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApiUser>
 *
 * @method ApiUser|null findOneBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null)
 * @method list<ApiUser> findAll()
 * @method list<ApiUser> findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, int|null $limit = null, int|null $offset = null)
 */
final class ApiUserRepository extends ServiceEntityRepository implements ApiUserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiUser::class);
    }

    public function find(mixed $id, mixed $lockMode = null, ?int $lockVersion = null): ApiUser
    {
        $user = parent::find($id, $lockMode, $lockVersion);

        if (!$user instanceof ApiUser) {
            throw new \LogicException(sprintf('Expected instance of %s or null.', ApiUser::class));
        }

        return $user;
    }

    public function findOneByEmail(string $email): ?ApiUser
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function add(ApiUser $user): void
    {
        $this->getEntityManager()->persist($user);

        $this->getEntityManager()->flush();
    }

    public function update(ApiUser $user): void
    {
        $this->getEntityManager()->flush();
    }

    public function delete(ApiUser $user): void
    {
        $user->setArchive(true);

        $this->getEntityManager()->flush();
    }
}
