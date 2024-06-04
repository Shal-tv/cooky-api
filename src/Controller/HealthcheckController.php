<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Service\HealthcheckService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class HealthcheckController
 *
 * @package App\Controller
 */
#[Route('/healthcheck', methods: ['GET'])]
final class HealthcheckController extends AbstractController
{

    /**
     * HealthcheckController Constructor.
     *
     * @param HealthcheckService  $healthcheckService
     */
    public function __construct(private readonly HealthcheckService $healthcheckService)
    {
    }

    /**
     * @return Response
     */
    #[Route('/ping')]
    public function ping() : Response
    {
        return new JsonResponse('pong');
    }

    /**
     * @return Response
     */
    #[Route('/health')]
    public function health() : Response
    {
        return new JsonResponse([
            'DB' => $this->healthcheckService->checkDBConnection()
        ]);
    }

}
