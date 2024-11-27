<?php

declare(strict_types=1);

namespace App\Domain\SecurityException;

use App\Domain\SecurityException\SecurityException;
use Slim\Exception\HttpUnauthorizedException;

class UnauthorizedException extends HttpUnauthorizedException
{
    public $message = 'JWT is invalid, user is unauthorized!';
}
