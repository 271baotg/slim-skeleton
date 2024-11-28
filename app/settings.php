<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Load environment variables
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError' => false,
                'logErrorDetails' => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                // Secret Key from environment
                'jwt.secret_key' => getenv('JWT_SECRET_KEY'),
                // Slim Settings
                'determineRouteBeforeAppMiddleware' => false,
                // Database settings from environment
                'db' => [
                    'driver' => getenv('DB_DRIVER'),
                    'host' => getenv('DB_HOST'),
                    'database' => getenv('DB_DATABASE'),
                    'username' => getenv('DB_USERNAME'),
                    'password' => getenv('DB_PASSWORD'),
                    'charset' => getenv('DB_CHARSET'),
                    'collation' => getenv('DB_COLLATION'),

                    'prefix' => '',
                ],
            ]);
        },
    ]);
};
