<?php

declare(strict_types=1);

namespace App\Domain\Jwt;

use App\Application\Middleware\JwtMiddleware;

class Jwt
{
    public function generateJwtToken($username, $userId)
    {
        global $settings;
        $header = json_encode(['type' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['username' => $username, 'exp' => time() + 7200, 'user_id' => $userId]);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac(
            'sha256',
            $base64UrlHeader . '.' . $base64UrlPayload,
            $settings->get('jwt.secret_key'),
            true,
        );
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwtToken = $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;

        return $jwtToken;
    }
}
