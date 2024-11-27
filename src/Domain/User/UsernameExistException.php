<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\DomainException\DomainRecordConflictException;

class UsernameExistException extends DomainRecordConflictException
{
    public $message = 'The user name is already exists!';
}
