<?php

declare(strict_types=1);

namespace App\Application\Actions\Authentication;

use App\Domain\Jwt\Jwt;
use App\Domain\SecurityException\UnauthorizedException;
use App\Domain\User\User;
use App\Domain\Utils\Pagination;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends AuthenticationAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $param = $this->request->getParsedBody();
        if (!$this->userRepository->verifyUser($param['username'], $param['password'])) {
            throw new UnauthorizedException($this->request, 'Please check your username or password !');
        } else {
            $user = User::where('username', $param['username'])->first();
            $userId = $user->id;
            $jwtService = new Jwt();
            $jwtToken = $jwtService->generateJwtToken($param, $userId);

            $res = [
                'token' => $jwtToken,
                'message' => 'Login succesfully',
            ];
            return $this->respondWithData($res);
        }
    }
}
