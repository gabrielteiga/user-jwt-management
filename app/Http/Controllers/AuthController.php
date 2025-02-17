<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Infrastructure\Auth\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthRequest $authRequest): JsonResponse
    {
        $authRequest->validated();

        $credentials = [
            'email'     => $authRequest->email,
            'password'  => $authRequest->password
        ];

        $login = $this->authService->login($credentials);

        return response()->json($login, 200);
    }
}
