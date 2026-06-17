<?php

declare(strict_types = 1);

namespace App\Infrastructure\Security\Voter;

use App\Infrastructure\Security\ApiUserAdapter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Uid\Uuid;

/**
 * @extends Voter<string, Uuid>
 */
final class UserVoter extends Voter
{
    public const string VIEW = 'USER_VIEW';

    public const string EDIT = 'USER_EDIT';

    public const string DELETE = 'USER_DELETE';

    public function __construct(private readonly AccessDecisionManagerInterface $accessDecisionManager)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [
                self::VIEW,
                self::EDIT,
                self::DELETE,
            ])
            && $subject instanceof Uuid;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof ApiUserAdapter) {
            return false;
        }

        if ($this->accessDecisionManager->decide($token, ['ROLE_SUPER_ADMIN'])) {
            return true;
        }

        /** @var Uuid $uuid */
        $uuid = $subject;

        return match ($attribute) {
            self::VIEW, self::EDIT, self::DELETE => $user->getApiUser()->getUuid() === $uuid->toString(),
            default => throw new \LogicException('This code should not be reached!') // TODO: EXCEPTIONS
        };
    }
}
