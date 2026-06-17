<?php

declare(strict_types = 1);

namespace App\Presentation\Controller\API\Users;

use App\Application\Query\User\GetUser;
use App\Presentation\Controller\MessageBusController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Uid\Uuid;

final class GetController extends MessageBusController
{
    #[Route(path: '/users/{uuid}', methods: 'GET')]
    #[IsGranted(attribute: 'ROLE_USER', message: 'Unauthorized.', statusCode: Response::HTTP_UNAUTHORIZED)]
    #[IsGranted(attribute: 'USER_VIEW', subject: 'uuid', message: 'User not found.', statusCode: Response::HTTP_NOT_FOUND)]
    public function __invoke(Uuid $uuid): Response
    {
        $result = $this->queryBus->dispatch(new GetUser($uuid));

        return $this->json($result, 200, [], ['groups' => ['read']]);
    }
}
