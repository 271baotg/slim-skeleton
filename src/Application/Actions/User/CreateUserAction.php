<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;

class CreateUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $newUser = new User();
        $newUser->username = $data['username'];
        $newUser->password = password_hash($data['password'], PASSWORD_BCRYPT);
        $newUser->fullname = $data['fullname'];
        $newUser->save();

        return $this->respondWithData($newUser->id);
    }
}
