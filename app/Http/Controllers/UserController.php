<?php

namespace App\Http\Controllers;

use App\Domain\Services\UserService;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(CreateUserRequest $request): JsonResponse
    {
        $request->validated();

        $user = $this->userService->createUser(
            $request->name,
            $request->email,
            $request->password,
            $request->cpf,
            $request->phone_number
        );

        return $user ?
            response()->json([
                'message'   => "User '{$user->name}' has been created successfully",
                'status'    => 'success',
                'user'      => $user
            ], 201) : 
            response()->json([
                'message'   => "Failed with the user creation. Try again and contact TargetIT if the problem persists.",
                'status'    => 'error'
            ], 422);
    }
}
