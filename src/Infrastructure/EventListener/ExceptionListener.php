<?php

declare(strict_types = 1);

namespace App\Infrastructure\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final readonly class ExceptionListener
{
    #[AsEventListener]
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = match (true) {
            $exception instanceof HttpExceptionInterface => $this->buildResponse($exception->getMessage(), $exception->getStatusCode()),
            default => $this->buildResponse('Ooops, something went wrong.', 500)
        };

        $event->setResponse($response);
    }

    private function buildResponse(string $message, int $statusCode): JsonResponse
    {
        return new JsonResponse([
            'code' => $statusCode,
            'message' => $message
        ], $statusCode);
    }
}
