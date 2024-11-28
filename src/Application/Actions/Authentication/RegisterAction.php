<?php
declare(strict_types=1);

namespace App\Application\Actions\Authentication;

use App\Domain\Jwt\Jwt;
use App\Domain\SecurityException\UnauthorizedException;
use App\Domain\User\User;
use App\Domain\Utils\Pagination;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterAction extends AuthenticationAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $param = $this->request->getParsedBody();
        $user = User::where('username', $param['username'])->first();
        if ($user) {
            throw new UnauthorizedException($this->request, 'Username already exist!');
        } else {
            $newUserId = $this->userRepository->create($param['username'], $param['password'], $param['fullname']);
            $jwtService = new Jwt();
            $jwtToken = $jwtService->generateJwtToken($param, $newUserId);

            $res = [
                'token' => $jwtToken,
                'message' => 'Your account had been succesfully created!',
            ];
            return $this->respondWithData($res);
        }
    }
}
