<?php

namespace App\Domain\Services;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class UserService {
    public UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(string $name, string $email, string $password, string $cpf, string $phone_number): User
    {
        $user = new User(
            $name,
            $email,
            $password,
            $cpf,
            $phone_number
        );

        return $this->userRepository->create($user);
    }

    public function getUserById(int $userId): User
    {
        return $this->userRepository->findUserById($userId);
    }
}