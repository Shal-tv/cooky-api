<?php

declare(strict_types = 1);

namespace App\Presentation\Controller\API\Users;

use App\Application\Command\User\DeleteUser;
use App\Presentation\Controller\MessageBusController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Uid\Uuid;

final class DeleteController extends MessageBusController
{
    #[Route(path: '/users/{uuid}', methods: 'DELETE')]
    #[IsGranted(attribute: 'ROLE_ADMIN', message: 'Unauthorized.', statusCode: Response::HTTP_UNAUTHORIZED)]
    #[IsGranted(attribute: 'USER_DELETE', subject: 'uuid', message: 'User not found.', statusCode: Response::HTTP_NOT_FOUND)]
    public function __invoke(Uuid $uuid): Response
    {
        $result = $this->commandBus->dispatch(new DeleteUser($uuid));

        return $this->json($result, 204);
    }
}
