<?php

namespace App\Infrastructure\Auth\JWT;

use App\Infrastructure\Auth\AuthServiceInterface;
use App\Infrastructure\Auth\JWT\UserJWT;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthJWTService implements AuthServiceInterface{
    public function login(array $credentials): array {
        $user = UserJWT::where('email', $credentials['email'])->first();
        if (is_null($user) || !$token = JWTAuth::fromUser($user)) {
            throw new HttpException(401, json_encode(
                [
                    'message'   => 'Invalid credentials',
                    'status'    => 'Error'
                ]
                ));
            }

        return [
            'access_token'  => $token,
            'message'       => "You're logged!",
            'status'        => 'success'
        ];
    }
}