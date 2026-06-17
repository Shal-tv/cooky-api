<?php

declare(strict_types = 1);

namespace App\Presentation\Controller\API\Users;

use App\Application\Query\User\ListUsers;
use App\Presentation\Controller\MessageBusController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ListingController extends MessageBusController
{
    #[Route(path: '/users', methods: 'GET')]
    #[IsGranted(attribute: 'ROLE_ADMIN', message: 'Unauthorized.', statusCode: Response::HTTP_UNAUTHORIZED)]
    public function __invoke(): Response
    {
        $result = $this->queryBus->dispatch(new ListUsers());

        return $this->json($result, 200, [], ['groups' => ['read']]);
    }
}
