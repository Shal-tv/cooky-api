<?php

use App\Kernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return static function (array $context): Kernel {
    $environment = $context['APP_ENV'] ?? 'dev';

    if (!is_string($environment)) {
        $environment = 'dev';
    }

    return new Kernel($environment, (bool) ($context['APP_DEBUG'] ?? false));
};
