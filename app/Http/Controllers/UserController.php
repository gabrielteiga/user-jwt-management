<?php

namespace App\Http\Controllers;

use App\Domain\Services\UserService;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $userId = auth()->id();

        $user = $this->userService->getUserById($userId);

        $response = [
            'id'            => $userId,
            'name'          => $user->name,
            'email'         => $user->email,
            'cpf'           => $user->cpf,
            'phone_number'  => $user->phone_number,
            'addresses'     => $user->addresses
        ];

        return response()->json(['user' => $response]);
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

    public function edit(EditUserRequest $request): JsonResponse
    {
        $request->validated();

        $bodyRequest = $request->onlyInRules();

        if(empty($bodyRequest)) 
            return response()->json([
                    'message'   => 'Nothing to update',
                    'status'    => 'success',
            ], 204);

        $userId = auth()->user()->id;
        $userUpdated = $this->userService->editUserData($userId, $bodyRequest);
        
        return response()->json($userUpdated, 200);
    }

    public function delete(): JsonResponse
    {
        $userId = auth()->user()->id;

        $status = $this->userService->deleteUser($userId);

        return $status ?
            response()->json([
                'message'   => 'User deleted successfully',
                'status'    => 'success'
            ], 200) : response()->json([
                'message'   => 'User cannot be deleted',
                'status'    => 'error'
            ]);
    }
}
