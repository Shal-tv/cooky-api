<?php

declare(strict_types = 1);

namespace App\Infrastructure\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final readonly class ExceptionListener
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    #[AsEventListener]
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $this->logger->error($exception->getMessage(), [
                'exception' => $exception,
            ]
        );

        $response = match (true) {
            $exception instanceof HttpExceptionInterface => $this->buildResponse($exception->getMessage(), $exception->getStatusCode()
            ),
            default => $this->buildResponse('Ooops, something went wrong.', 500
            )
        };

        $event->setResponse($response
        );
    }

    private function buildResponse(string $message, int $statusCode): JsonResponse
    {
        return new JsonResponse([
            'code' => $statusCode,
            'message' => $message
        ], $statusCode
        );
    }
}
