<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\SecurityException\UnauthorizedException;
use App\Domain\User\User;
use App\Domain\User\UsernameExistException;
use App\Domain\User\UserRepository;
use App\Domain\Utils\ListResponseModel;
use App\Domain\Utils\Pagination;

class UserRepositoryImpl implements UserRepository
{
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

    public function getUsersByPagination($pagination): ListResponseModel
    {
        $resultPagination = Pagination::validate($pagination);

        $offset = ($resultPagination->getPage() - 1) * $resultPagination->getPageSize();

        $limit = $resultPagination->getPageSize();

        $users = User::query()->offset($offset)->limit($limit)->get()->toArray();

        $total = count($users);

        $result = new ListResponseModel();
        $result->setTotal($total);
        $result->setData($users);
        $result->setPagination($pagination);

        return $result;
    }

    public function create($username, $passsword, $fullname): int
    {
        // Check if the username already exists in the database
        if (User::where('username', $username)->exists()) {
            // Throw the exception if the username already exists
            throw new UsernameExistException("Username '$username' already exists.");
        }

        $newUser = new User();
        $newUser->username = $username;
        $newUser->password = password_hash($passsword, PASSWORD_BCRYPT);
        $newUser->fullname = $fullname;
        $newUser->save();

        return $newUser->id;
    }

    public function verifyUser($username, $password): bool
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return false;
        }

        return password_verify($password, $user->password);
    }
}
