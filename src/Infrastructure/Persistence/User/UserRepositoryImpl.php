<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;

class UserRepositoryImpl implements UserRepository
{
    private array $users;

    /**
     * @param User[]|null $users
     */
    public function __construct(array $users = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return User::all()->toArray();
    }

    public function create($username, $passsword, $fullname): int
    {
        $user = new User($username, $fullname, $passsword);
        $user->save();
        return $user->id;
    }
}
