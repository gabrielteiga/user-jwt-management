<?php

namespace App\Infrastructure\Auth\JWT;

use App\Models\User;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserJWT extends User implements JWTSubject 
{
    protected $table = 'users';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
}
