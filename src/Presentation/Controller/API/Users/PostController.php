<?php

declare(strict_types = 1);

namespace App\Presentation\Controller\API\Users;

use App\Application\Command\User\CreateUser;
use App\Presentation\Controller\MessageBusController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends MessageBusController
{
    #[Route(path: '/users', methods: 'POST')]
    public function __invoke(#[MapRequestPayload] CreateUser $createUser): Response
    {
        $result = $this->commandBus->dispatch($createUser);

        return $this->json($result, 201, [], ['groups' => ['write']]);
    }
}
