<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface UserRepositoryInterface {
    public function create(User $user): User;
    public function findUserById(int $userId): ?User;
    public function updateUser(User $user): ?User;
    public function deleteById(int $userId): bool;
}