<?php

declare(strict_types = 1);

namespace App\Presentation\Controller\API;

use App\Application\Query\Healthcheck\GetHealthcheck;
use App\Presentation\Controller\MessageBusController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HealthcheckController extends MessageBusController
{
    #[Route('/healthcheck', methods: ['GET'])]
    public function get(): Response
    {
        $result = $this->queryBus->dispatch(new GetHealthcheck());

        return $this->json($result);
    }
}
