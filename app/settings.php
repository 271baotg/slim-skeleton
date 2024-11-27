<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError' => false,
                'logErrorDetails' => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker'])
                        ? 'php://stdout'
                        : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                //temporary-secret-key
                'jwt.secret_key' =>
                    'a247e19d0ac4c080a45c77187ad29506e59fdc7b81839820a7fc50618e2dfa61',
                // Slim Settings
                'determineRouteBeforeAppMiddleware' => false,
                'db' => [
                    'driver' => 'mysql',
                    'host' => 'localhost',
                    'database' => 'user_management',
                    'username' => 'root',
                    'password' => 'giabao2017',
                    'charset' => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix' => '',
                ],
            ]);
        },
    ]);
};
