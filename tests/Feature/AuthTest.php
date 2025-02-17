<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_example(): void
    {
        $userData = [
            'name'          => 'gabriel test',
            'email'         => 'teste@gabriel.com',
            'password'      => 'testegabriel',
            'cpf'           => '03303303394',
            'phone_number'  => '55998765432'
        ];

        $response = $this->postJson('api/user', $userData);

        $response->assertStatus(201);

        $credentials = [
            'email'     => $userData['email'],
            'password'  => $userData['password']
        ];

        $response = $this->postJson('api/auth', $credentials);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token']);
    }
}
