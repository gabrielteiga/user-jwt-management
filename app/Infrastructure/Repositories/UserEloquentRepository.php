<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\User as ModelsUser;

class UserEloquentRepository implements UserRepositoryInterface {
    public function create(User $user): User
    {
        $userModel = ModelsUser::create([
            'name'          => $user->name,
            'email'         => $user->email,
            'password'      => $user->password,
            'cpf'           => $user->cpf,
            'phone_number'  => $user->phone_number
        ]);

        return $this->createUserfromEloquentModel($userModel);
    }

    public function findUserById(int $userId): ?User
    {
        $userModel = ModelsUser::with('address')->find($userId);

        return $this->createUserfromEloquentModel($userModel);
    }

    private function createUserfromEloquentModel(ModelsUser $userModel): User
    {
        return new User(
            $userModel->name,
            $userModel->email,
            $userModel->password,
            $userModel->cpf,
            $userModel->phone_number,
            $userModel->address->all()
        );
    }
}