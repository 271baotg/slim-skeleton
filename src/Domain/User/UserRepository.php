<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Utils\ListResponseModel;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    public function create($username, $password, $fullname): int;

    public function getUsersByPagination($pagination): ListResponseModel;

    public function verifyUser($username, $password): bool;
}
