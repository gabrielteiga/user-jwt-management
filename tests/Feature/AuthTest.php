<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public array $userData = [
        'name'          => 'gabriel test',
        'email'         => 'teste@gabriel.com',
        'password'      => 'testegabriel',
        'cpf'           => '03303303394',
        'phone_number'  => '55998765432'
    ];

    public function test_user_can_be_authenticated_after_created(): void
    {
        $response = $this->postJson('api/user', $this->userData);

        $response->assertStatus(201);

        $credentials = [
            'email'     => $this->userData['email'],
            'password'  => $this->userData['password']
        ];

        $response = $this->postJson('api/auth', $credentials);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token']);
    }

    public function test_user_cannot_be_authenticated_before_created(): void
    {
        $credentials = [
            'email'     => $this->userData['email'],
            'password'  => $this->userData['password']
        ];

        $response = $this->postJson('api/auth', $credentials);

        $response->assertStatus(401);
    }
}
