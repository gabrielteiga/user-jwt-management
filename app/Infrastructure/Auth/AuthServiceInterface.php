<?php

namespace App\Infrastructure\Auth;

interface AuthServiceInterface {
    public function login(array $credentials): array;
}