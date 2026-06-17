<?php

declare(strict_types = 1);

namespace App\Presentation\Controller;

use App\Application\Command\CommandBus;
use App\Application\Event\EventBus;
use App\Application\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class MessageBusController extends AbstractController
{
    public function __construct(
        protected readonly CommandBus $commandBus,
        protected readonly QueryBus $queryBus,
        protected readonly EventBus $eventBus
    ) {
    }
}
