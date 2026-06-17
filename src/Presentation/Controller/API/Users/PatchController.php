<?php

declare(strict_types = 1);

namespace App\Presentation\Controller\API\Users;

use App\Application\Command\User\UpdateUser;
use App\Presentation\Controller\MessageBusController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Uid\Uuid;

final class PatchController extends MessageBusController
{
    #[Route(path: '/users/{uuid}', methods: 'PATCH')]
    #[IsGranted(attribute: 'ROLE_USER', message: 'Unauthorized.', statusCode: Response::HTTP_UNAUTHORIZED)]
    #[IsGranted(attribute: 'USER_EDIT', subject: 'uuid', message: 'User not found.', statusCode: Response::HTTP_NOT_FOUND)]
    public function __invoke(Uuid $uuid, #[MapRequestPayload] UpdateUser $updateUser): Response
    {
        $updateUser->setUuid($uuid);

        $result = $this->commandBus->dispatch($updateUser);

        return $this->json($result, 200, [], ['groups' => ['read']]);
    }
}
